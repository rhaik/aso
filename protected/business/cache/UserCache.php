<?php
/**
 * 
 * 用户缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class UserCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_USER_';
	/**
	 *
	 *
	 * 加载缓存数据
	 *
	 * @return array
	 */
	public function loadCacheData($id) {
		return UserModel::model ()->findByPk ( $id )->attributes;
	}
}