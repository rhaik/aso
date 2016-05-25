<?php
/**
 * 
 * 用户动作日志管理
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class UserActionController extends Controller {
	/**
	 * (non-PHPdoc)
	 *
	 * @see CController::filters()
	 */
	public function filters() {
		return array (
				array (
						'TokenFilter' 
				),
				array (
						'RequestFilter + Create' 
				) 
		);
	}
	
	/**
	 * 用户操作日志
	 */
	public function actionCreate() {
		$component = Yii::app ()->getComponent ( 'requestFilter' );
		if (! empty ( $component->paramsData )) {
			$action = $this->getId () . '.' . $this->getAction ()->getId ();
			
			$userId = $component->paramsData ['user_id'] = intval ( $this->getUserId() );
			$appTaskId = intval ( $component->paramsData ['app_task_id'] );
			$appId = intval ( $component->paramsData ['app_id'] );
			$action = intval ( $component->paramsData ['action'] );
			if (empty ( $userId ) || empty ( $appTaskId ) || empty ( $appId ) || empty ( $action )) {
				throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_LACK_ERROE );
			}
			
			$message = CJSON::encode ( $component->paramsData );
			if (Yii::app ()->amqp->bindExchangeToQueue ( 'user.ExUserAction', 'user.QeUserAction' )->publish ( $message )) {
				$this->renderJSON ();
			} else {
				$params = array ();
				foreach ( $component->paramsData as $k => $v ) {
					$params [] = $k . ':' . $v;
				}
				Yii::log ( "params:" . implode ( ';', $params ), CLogger::LEVEL_INFO, $action );
				throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_MQ_MESSAGE );
			}
		} else {
			throw new CHttpException ( 200, '非法请求', 400 );
		}
	}
}