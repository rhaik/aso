<?php
/**
 * 
 * 月/年/总排行列表缓存(month/year/total)
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class IncomeRankCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_INCOME_RANK_';
	/**
	 * 加载缓存数据
	 *
	 * @return array
	 */
	public function loadCacheData($key) {
		$data = array ();
		if ($key == 'month') {
			$startTime = mktime ( 0, 0, 0, date ( 'm' ), 1, date ( 'Y' ) );
		} else if ($key == 'year') {
			$startTime = mktime ( 0, 0, 0, 1, 1, date ( 'Y' ) );
		} else {
			$startTime = mktime ( 0, 0, 0, 1, 1, 2015 );
		}
		$rankArray = UserIncomeLogModel::model ()->findAll ( array (
				'select' => 'sum(amount) as amount,user_id',
				'condition' => 'operator_time>=' . $startTime . ' AND operator_time<=' . time () . '  AND  type = 1 AND `action` < 5',
				'group' => 'user_id',
				'order' => 'amount DESC',
				'limit' => 10 
		) );
		
		if (! empty ( $rankArray )) {
			foreach ( $rankArray as $k => $v ) {
				$u = UserModel::model ()->findByPk ( $v->user_id );
				$data [$k] = [ 
						'userName' => $u->name,
						'userAvatar' => $u->avatar,
						'total' => $v->amount 
				];
			}
		}
		return $data;
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see Cache::getExpire()
	 */
	public function getExpire() {
		$time = mktime ( 23, 59, 59, date ( 'm' ), date ( 'd' ), date ( 'Y' ) ) - time ();
		return $time > 0 ? $time : 24 * 60 * 60;
	}
}