<?php
/**
 * 
 * 提现列表缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class UserEnchashmentListCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_USER_ENCHASHMENT_LIST_';
	/**
	 *
	 * 加载缓存数据
	 *
	 * @return array
	 */
	public function loadCacheData($userId) {
		$enchashmentArray = UserEnchashmentModel::model ()->findAll ( [ 
				'condition' => 'user_id=' . intval ( $userId ),
				'order' => 'times DESC' 
		] );
		if (! empty ( $enchashmentArray )) {
			foreach ( $enchashmentArray as $k => $v ) {
				$data [$k] = $v->attributes;
				$data [$k] ['createTime'] = date ( 'Y-m-d H:i:s', $v->times );
			}
		} else
			$data = array ();
		return $data;
	}
}