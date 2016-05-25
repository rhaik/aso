<?php
/**
 * 
 * 系统消息缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class SystemMessageCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_SYSTEM_MESSAGE_';
	/**
	 *
	 * 加载缓存数据
	 *
	 * @param integer $userId        	
	 *
	 * @return array
	 */
	public function loadCacheData($id) {
		return UserNoticeModel::model ()->findByPk($id)->attributes;
	}
}