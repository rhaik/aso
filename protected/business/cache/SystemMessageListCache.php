<?php
/**
 * 
 * 系统消息列表缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class SystemMessageListCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_SYSTEM_MESSAGE_LIST_';
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
		$pageOn = isset ( $params [1] ) && intval ( $params [1] ) > 0 ? intval ( $params [1] ) : 1;
		$pageSize = 10;
		
		$criteria = new CDbCriteria ();
		$criteria->alias = 'm';
		$criteria->compare ( 'm.user_id', $userId );
		$criteria->compare ( 'm.user_id', 0, false, 'OR' );
		$criteria->offset = ($pageOn - 1) * $pageSize;
		$criteria->limit = $pageSize;
		$criteria->order = "m.is_read ASC, m.id DESC";
		
		$messageArray = UserNoticeModel::model ()->findAll ( $criteria );
		
		if (! empty ( $messageArray )) {
			foreach ( $messageArray as $k => $v ) {
				$data [$k] = $v->attributes;
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
		return 24 * 60 * 60;
	}
}