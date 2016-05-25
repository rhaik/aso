<?php
/**
 * 
 * 用户任务列表缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class UserTaskListCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_USER_TASK_LIST_';
	/**
	 *
	 * 加载缓存数据
	 *
	 * @return array
	 */
	public function loadCacheData($uid) {
		$uid = intval ( $uid );
		$data = array ();
		$userTaskModelArray = UserTaskModel::model ()->findAllByAttributes ( [ 
				'user_id' => $uid 
		] );
		$data = array ();
		if (! empty ( $userTaskModelArray )) {
			foreach ( $userTaskModelArray as $v ) {
				$data [$v->task_id] = $v->status;
			}
		}
		return $data;
	}
}