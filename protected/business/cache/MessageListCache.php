<?php
/**
 * 
 * 消息列表缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class MessageListCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_MESSAGE_LIST_';
	/**
	 *
	 * 加载缓存数据
	 *
	 * @param integer $userId        	
	 *
	 * @return array
	 */
	public function loadCacheData($params) {
		$params = explode ( '_', $params );
		if (empty ( $params ))
			return array ();
		
		$userId = intval ( $params [0] ); // 用户ID
		$type = isset ( $params [1] ) && in_array ( $params [1], [ 
				1,
				2 
		] ) ? intval ( $params [1] ) : 1; // 消息类型(1:应用2:好友)
		$pageOn = isset ( $params [2] ) && intval ( $params [2] ) > 0 ? intval ( $params [2] ) : 1;
		$pageSize = 10;
		
		$criteria = new CDbCriteria ();
		$criteria->alias = 'm';
		$criteria->select = "m.*,app.id as appId,app.name as appName,app.icon as appIcon,task.name as taskName,task.start_time as taskStartTime,
				task.action as taskAction,task.id as taskId,task.amount as taskAmount, task.friends_amount as taskFriendsAmount, ut.finish_time as finishTime";
		$criteria->join = "LEFT JOIN " . UserTaskModel::model ()->tableName () . " AS ut ON m.user_task_id = ut.id 
				LEFT JOIN " . AppModel::model ()->tableName () . " AS app ON ut.app_id = app.id 
				LEFT JOIN " . AppTaskModel::model ()->tableName () . " AS task ON ut.task_id = task.id";
		$criteria->compare ( 'm.user_id', $userId );
		$criteria->compare ( 'm.type', 1 );
		$criteria->offset = ($pageOn - 1) * $pageSize;
		$criteria->limit = $pageSize;
		$criteria->order = "m.is_read ASC, m.id DESC";
		
		$messageArray = UserAppNoticeModel::model ()->findAll ( $criteria );
		
		if (! empty ( $messageArray )) {
			foreach ( $messageArray as $k => $v ) {
				$data [$k] = $v->attributes;
				$data [$k] ['appId'] = $v->appId;
				$data [$k] ['appName'] = $v->appName;
				$data [$k] ['appIcon'] = $v->appIcon;
				$data [$k] ['taskId'] = $v->taskId;
				$data [$k] ['taskName'] = $v->taskName;
				$data [$k] ['taskStartTime'] = $v->taskStartTime;
				$data [$k] ['taskAmount'] = $v->taskAmount;
				$data [$k] ['taskFriendsAmount'] = $v->taskFriendsAmount;
				$data [$k] ['taskAction'] = $v->taskAction;
				$data [$k] ['finishTime'] = $v->finishTime;
				$data [$k] ['userName'] = CacheM::get ( 'User', $v->user_id );
			}
		} else
			$data = array ();
		
		return $data;
	}
	/**
	 * (non-PHPdoc)
	 * 
	 * @see Cache::getExpire()
	 */
	public function getExpire() {
		return 1 * 60 * 60;
	}
}