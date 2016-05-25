<?php
ini_set ( 'default_socket_timeout', - 1 );
/**
 *
 * @name 消息记录到日志表
 * @author zhanghaisong 2014-09-29
 *        
 */
class ReceiveCommand extends CConsoleCommand {
	/**
	 * 临时缓存数据
	 *
	 * @var array
	 */
	public $data = array ();
	public function run($args) {
		$queue = Yii::app ()->amqp->bindQueueToExchange ( 'user.QeUserAction', 'user.ExUserAction' );
		
		while ( true ) {
			$i = 0;
			$this->data = array ();
			while ( $queue->declareQueue () ) {
				++ $i;
				$messages = $queue->get ( AMQP_AUTOACK );
				$body = CJSON::decode ( $messages->getBody () );
				if (is_array ( $body )) {
					$this->data [] = $body;
				}
				
				if ($i % 100 == 0) {
					break;
				}
			}
			$this->saveData ();
			sleep ( 2 );
		}
	}
	/**
	 *
	 * 保存数据
	 *
	 * @param array $data        	
	 */
	public function saveData() {
		if (empty ( $this->data ))
			return false;
		
		$transaction = Yii::app ()->money->beginTransaction ();
		$dbConnection = Yii::app ()->money;
		$dbConnection->setActive ( true );
		$builder = $dbConnection->schema->commandBuilder;
		try {
			$incomeData = $noticeData = $friendsIncomeData = $friendsNoticeData = array ();
			foreach ( $this->data as $k => $data ) {
				// 如果任务完成不能再重复操作
				$userTask = UserTaskModel::model ()->findByAttributes ( [ 
						'user_id' => $data ['user_id'],
						'task_id' => $data ['app_task_id'] 
				] );
				if (empty ( $userTask )) {
					$userTask = new UserTaskModel ();
					$userTask->user_id = $data ['user_id'];
					$userTask->task_id = $data ['app_task_id'];
					$userTask->app_id = $data ['app_id'];
					$userTask->status = 1;
					$userTask->finish_time = 0;
					$userTask->save ();
				} else if ($userTask->status == 2) {
					unset ( $this->data [$k] );
					continue;
				}
				$data ['user_task_id'] = $this->data [$k] ['user_task_id'] = $userTask->id;
				
				
				$taskModel = AppTaskModel::model ()->findByPk ( $data ['app_task_id'] );
				$userModel = UserModel::model ()->findByPk ( $data ['user_id'] );
				if (empty ( $userModel )) {
					continue;
				}
				// 更新任务状态
				$taskStatus = $this->updateUserTaskStatus ( $data, $taskModel->action );
				
				if ($taskStatus != UserTaskModel::ACTION_UNFINISHED) { // 未完成
					continue;
				}
				$incomeData [] = [ 
						'user_id' => $data ['user_id'],
						'user_task_id' => $data ['user_task_id'],
						'action' => in_array ( $data ['actionType'], UserIncomeLogModel::getActionArray () ) ? $data ['actionType'] : 1,
						'amount' => $taskModel->amount,
						'total_amount' => $userModel->amount + $taskModel->amount,
						'type' => 1,
						'operator_time' => $data ['action_time'],
						'remarks' => $this->getIncomeRemarksTemplete ( [ 
								'userName' => $userModel->name,
								'taskName' => $taskModel->name,
								'amount' => $taskModel->amount 
						] ) 
				];
				// 更新用户总金额
				UserModel::model ()->updateByPk ( $data ['user_id'], array (
						'amount' => $userModel->amount + $taskModel->amount 
				) );
				
				$noticeData [] = [ 
						'user_id' => $data ['user_id'],
						'user_task_id' => $data ['user_task_id'],
						'action' => in_array ( $data ['actionType'], UserAppNoticeModel::getActionArray () ) ? $data ['actionType'] : 1,
						'action_time' => $data ['action_time'],
						'type' => 1,
						'remarks' => $this->getNoticeTemplete ( [ 
								'taskName' => $taskModel->name 
						] ) 
				];
				
				// 如果当前用户是好友邀请
				$user = UserInvitationFriendsModel::model ()->findByAttributes ( [ 
						'friends' => $data ['user_id'] 
				] );
				
				if (! empty ( $user )) {
					$friendsUserModel = UserModel::model ()->findByPk ( $user->user_id );
					$friendsIncomeData [] = [ 
							'user_id' => $user->user_id,
							'user_task_id' => $data ['user_task_id'],
							'action' => UserIncomeLogModel::ACTION_FRIENDS,
							'amount' => $taskModel->friends_amount,
							'total_amount' => $friendsUserModel->amount + $taskModel->friends_amount,
							'type' => 1,
							'operator_time' => $data ['action_time'],
							'remarks' => $this->getFriendsIncomeRemarksTemplete ( [ 
									'userName' => $userModel->name,
									'taskName' => $taskModel->name,
									'amount' => $taskModel->amount,
									'friends_amount' => $taskModel->friends_amount 
							] ) 
					];
					// 更新用户总金额
					UserModel::model ()->updateByPk ( $user->user_id, array (
							'amount' => $friendsUserModel->amount + $taskModel->friends_amount 
					) );
					
					$friendsNoticeData [] = [ 
							'user_id' => $user->user_id,
							'user_task_id' => $data ['user_task_id'],
							'action' => UserAppNoticeModel::ACTION_FRIENDS,
							'action_time' => $data ['action_time'],
							'type' => 2,
							'remarks' => $this->getFriendsIncomeRemarksTemplete ( [ 
									'userName' => $userModel->name,
									'taskName' => $taskModel->name,
									'amount' => $taskModel->amount,
									'friends_amount' => $taskModel->friends_amount 
							] ) 
					];
				}
			}
			if (count ( $this->data ) > 0) {
				// 保存操作日志
				$command = $builder->createMultipleInsertCommand ( UserAppLogModel::model ()->tableName (), $this->data );
				$command->execute ();
				
				if (! empty ( $incomeData )) {
					// 保存收支
					$command = $builder->createMultipleInsertCommand ( UserIncomeLogModel::model ()->tableName (), $incomeData );
					$command->execute ();
					
					// 完成任务发送消息
					$command = $builder->createMultipleInsertCommand ( UserAppNoticeModel::model ()->tableName (), $noticeData );
					$command->execute ();
					
					// 执行好友分成
					if (! empty ( $friendsIncomeData )) {
						$command = $builder->createMultipleInsertCommand ( UserIncomeLogModel::model ()->tableName (), $friendsIncomeData );
						$command->execute ();
						
						// 完成任务发送消息
						$command = $builder->createMultipleInsertCommand ( UserAppNoticeModel::model ()->tableName (), $friendsNoticeData );
						$command->execute ();
					}
				}
				
				
			}
			$transaction->commit ();
			//更新缓存
			if (count ( $this->data )) {
				foreach($this->data as $v) {
					//更新任务缓存
					CacheM::set('UserTaskList', $v['user_id']);		
					//更新用户缓存
					CacheM::set('User', $v['user_id']);
					//更新用户OPENID缓存
					CacheM::set('UserOpenId', $v['user_id']);
					//更新用户统计缓存
					CacheM::set('UserStatistics', $v['user_id']);
					//更新消息缓存
					CacheM::set ( 'Message', $v['user_id']);
					//更新app应用消息列表缓存
					CacheM::set ( 'MessageList', $v ['user_id'] . '_1_1' );
					
				}
			}
			//更新好友缓存
			if (! empty ( $friendsIncomeData )) {
				foreach($friendsIncomeData as $v) {
					//更新用户缓存
					CacheM::set('User', $v['user_id']);
					//更新用户OPENID缓存
					CacheM::set('UserOpenId', $v['user_id']);
					//更新用户统计缓存
					CacheM::set('UserStatistics', $v['user_id']);
					//更新消息缓存
					CacheM::set ( 'Message', $v['user_id']);
					//更新app应用消息列表缓存
					CacheM::set ( 'MessageList', $v ['user_id'] . '_2_1' );
				}
			}
			echo $message = "成功处理数据:" . count ( $this->data ) . "条\r\n";
			Yii::log ( $message, CLogger::LEVEL_INFO, 'userAction.ReceiveCommand' );
		} catch ( Exception $e ) {
			$transaction->rollback ();
			echo $e->getMessage () . '\r\n';
			Yii::log ( "data:" . serialize ( $this->data ) . ",error:" . $e->getMessage (), CLogger::LEVEL_INFO, 'userAction.ReceiveCommand' );
		}
	}
	/**
	 *
	 * 更新用户任务状态
	 *
	 * @param array $data        	
	 * @param string $action        	
	 *
	 * @return integer 返回用户任务状态
	 */
	public function updateUserTaskStatus($data, $action) {
		// 计算当前动作是否完成
		$actionData = UserAppLogModel::model ()->findByAttributes ( [ 
				'user_id' => $data ['user_id'],
				'app_task_id' => $data ['app_task_id'] 
		] );
		
		$isFinish = 1;
		$currentAction [] = $data ['action'];
		if (! empty ( $actionData )) {
			foreach ( $actionData as $v ) {
				$currentAction [] = $v->action;
			}
		}
		$actionArray = explode ( ',', $action );
		$isFinish = count ( array_diff ( $actionArray, $currentAction ) ) ? 1 : 2;
		// 更新用户任务完成状态
		if ($isFinish == 2) {
			UserTaskModel::model ()->updateByPk ( $data ['user_task_id'], [ 
					'status' => $isFinish,
					'finish_time' => $data ['action_time'] 
			] );
		}
		return $isFinish;
	}
	/**
	 * 获取好友收支备注模板
	 *
	 * @param array $data        	
	 *
	 * @return string
	 */
	public function getFriendsIncomeRemarksTemplete($data) {
		return $data ['userName'] . ':完成了<' . $data ['taskName'] . '>的试用,并获得收益' . $data ['amount'] . '元.给你提供分成' . $data ['friends_amount'] . '元.';
	}
	/**
	 * 获取收支备注模板
	 *
	 * @param array $data        	
	 *
	 * @return string
	 */
	public function getIncomeRemarksTemplete($data) {
		return $data ['userName'] . '完成了<' . $data ['taskName'] . '>的试用,并获得收益' . $data ['amount'] . '元.';
	}
	/**
	 *
	 * 获取消息通知备注模板
	 *
	 * @param array $data        	
	 *
	 * @return string
	 */
	protected function getNoticeTemplete($data) {
		return $data ['actionName'] . '完成,试用完后获得奖励.';
	}
	/**
	 * 获取动作名称
	 *
	 * @param integer $action        	
	 *
	 * @return string
	 */
	public function getActionName($action) {
		$actionArray = [ 
				1 => '搜索',
				2 => '下载',
				3 => '浏览' 
		];
		return $actionArray [$action];
	}
}