<?php
/**
 * 
 * 根据OpenId缓存用户信息
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class UserOpenIdCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_USER_OPENID_';
	/**
	 * 
	 * 加载缓存数据
	 * @param string $openid	用户OpenId
	 * 
	 * @return array
	 */
	public function loadCacheData($openid) {
		$user = UserModel::model ()->findByAttributes ( [ 
				'openid' => $openid 
		] );
		if (! empty ( $user )) {
			return $user->attributes;
		}
		return array();
	}
}