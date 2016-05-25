<?php
/**
 * 
 * 消息缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class MessageCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_MESSAGE_';
	/**
	 *
	 * 加载缓存数据
	 *
	 * @param integer $userId        	
	 *
	 * @return array
	 */
	public function loadCacheData($id) {
		$userId = intval ( $id );
		// app未读消息数
		$data ['appMessage'] ['count'] = $this->getUnReadCount ( $userId, 1 );
		if ($data ['appMessage'] ['count'] > 0) {
			$data ['appMessage'] ['data'] = $this->getUnReadFirst ( $userId, 1 );
		} else
			$data ['appMessage'] ['data'] = [ ];
			
			// 好友未读消息数
		$data ['friendMessage'] ['count'] = $this->getUnReadCount ( $userId, 2 );
		if ($data ['friendMessage'] ['count'] > 0) {
			$data ['friendMessage'] ['data'] = $this->getUnReadFirst ( $userId, 2 );
		} else
			$data ['friendMessage'] ['data'] = [ ];
			
			// 系统未读消息数
		$data ['systemMessage'] ['count'] = $this->getUnReadCount ( $userId, 3 );
		if ($data ['systemMessage'] ['count'] > 0) {
			$data ['systemMessage'] ['data'] = $this->getUnReadFirst ( $userId, 3 );
		} else
			$data ['systemMessage'] ['data'] = [ ];
		
		return $data;
	}
	/**
	 * 获取未读消息第一条
	 *
	 * @param string $type        	
	 */
	public function getUnReadFirst($userId, $type) {
		if ($type == 3) {
			return UserNoticeModel::model ()->find ( [ 
					'condition' => 'user_id = ' . $userId . ' AND `is_read` = 0',
					'order' => 'is_read ASC,id DESC' 
			] )->attributes;
		} else {
			return UserAppNoticeModel::model ()->find ( [ 
					'condition' => 'user_id = ' . $userId . ' AND type=' . $type . ' AND `is_read` = 0',
					'order' => 'is_read ASC,id DESC' 
			] )->attributes;
		}
	}
	/**
	 * 获取未读消息数
	 *
	 * @param string $type        	
	 */
	public function getUnReadCount($userId, $type) {
		if ($type == 3) {
			return UserNoticeModel::model ()->countByAttributes ( [ 
					'user_id' => $userId,
					'is_read' => 0 
			] );
		} else {
			return UserAppNoticeModel::model ()->countByAttributes ( [ 
					'user_id' => $userId,
					'type' => $type,
					'is_read' => 0 
			] );
		}
	}
}