<?php
/**
 * 
 * 任务列表缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class TaskListCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_TASK_LIST_';
	/**
	 *
	 * 加载缓存数据
	 *
	 * @return array
	 */
	public function loadCacheData() {
		$data = array ();
		$taskArray = AppTaskModel::model ()->with ( 'app' )->sort()->findAll ( 'start_time<' . time () . ' AND end_time>' . time () );
		if (! empty ( $taskArray )) {
			foreach ( $taskArray as $k => $v ) {
				$data [$k] = $v->attributes;
				$data [$k] ['appName'] = $v->app->name;
				$data [$k] ['appIcon'] = $v->app->icon;
				$data [$k] ['appUrl'] = $v->app->url;
				if (time () < $v->end_time) {
					$times [] = $v->end_time;
				}
			}
			$this->expire = $times ? min ( $times ) - time () : mktime ( 23, 59, 59, date ( 'm' ), date ( 'd' ), date ( 'Y' ) ) - time ();
		}
		return $data;
	}
}