<?php
/**
 * 
 * 任务缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class TaskCache extends Cache {
	/**
	 * 缓存KEY
	 * 
	 * @var string
	 */
	protected $cacheKey = 'CACHE_TASK_';
	/**
	 *
	 *
	 *
	 * 加载缓存数据
	 *
	 * @return array
	 */
	public function loadCacheData($id) {
		$data = [];
		$taskArray = AppTaskModel::model ()->with ( 'app' )->findByPk ( $id );
		if (! empty ( $taskArray )) {
			$data = $taskArray->attributes;
			$data ['appName'] = $taskArray->app->name;
			$data ['appIcon'] = $taskArray->app->icon;
			$data ['appUrl'] = $taskArray->app->url;
		}
		return $data;
	}
}