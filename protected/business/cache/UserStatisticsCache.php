<?php
/**
 * 
 * 用户统计缓存
 *
 * @author zhanghaisong 2014-04-15
 *
 */
class UserStatisticsCache extends Cache {
	/**
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = 'CACHE_USER_STATISTICS_';
	/**
	 *
	 * @var integer
	 */
	public $userId = 0;
	/**
	 *
	 * 加载缓存数据
	 *
	 * @return array
	 */
	public function loadCacheData($id) {
		$this->userId = intval ( $id );
		
		$data = CacheM::get ( 'User', $this->userId );
		if (! empty ( $data )) {
			// 注册天数
			$data ['registerDay'] = floor ( (time () - $data ['registration_time']) / 86400 );
			
			// 邀请人数
			$data ['userFriends'] = UserInvitationFriendsModel::model ()->countByAttributes ( [ 
					'user_id' => $id 
			] );
			$data['appAmount'] = $this->getAppTotalAmount();
			// 好友奖励
			$data ['userFriendsAmount'] = $this->getFriendsAmount (); 
			                                                          
			// 月排行
			$data ['rankMonth'] = UserIncomeLogModel::model ()->count ( array (
					'select' => 'sum(amount) as total',
					'condition' => 'user_id!=' . $id . ' AND  operator_time>=' . mktime ( 0, 0, 0, date ( 'm' ), 1, date ( 'Y' ) ) . ' AND operator_time<=' . time () . ' AND type = 1',
					'group' => 'user_id',
					'having' => 'total>=' . $data ['amount'] 
			) );
			$data ['rankMonth'] = $data ['rankMonth'] + 1;
			
			// 总排行
			$data ['rankTotal'] = UserIncomeLogModel::model ()->count ( array (
					'select' => 'sum(amount) as total',
					'condition' => 'user_id!=' . $id . ' AND type = 1',
					'group' => 'user_id',
					'having' => 'total>' . $data ['amount'] 
			) );
			$data ['rankTotal'] = $data ['rankTotal'] + 1;
			
			// 本月收入
			$data ['currentMonth'] = $this->getIncomeByMonth ( date ( 'm' ) );
			
			// 上月收入
			$data ['lastMonth'] = $this->getIncomeByMonth ( date ( 'm' ) - 1 );
			
			// 昨日应用试用收入
			$data ['yesterdayAppAmount'] = $this->getIncomeByDay ( 1, 1 );
			
			// 昨日好友分成收入
			$data ['yesterdayFriendsAmount'] = $this->getIncomeByDay ( 1, 0 );
			
			// 最近七天应用试用收入
			$data ['7dayAppAmount'] = $this->getIncomeByDay ( 7, 1 );
			
			// 最近七天好友分成收入
			$data ['7dayFriendsAmount'] = $this->getIncomeByDay ( 7, 0 );
			
			// 最近30天应用试用收入
			$data ['30dayAppAmount'] = $this->getIncomeByDay ( 30, 1 );
			
			// 最近30天好友分成收入
			$data ['30dayFriendsAmount'] = $this->getIncomeByDay ( 30, 0 );
			
		}
		/* echo "<pre>";
		print_r ( $data );
		exit (); */
		return $data;
	}
	/**
	 * 根据月份获取收入
	 *
	 * @param string $month        	
	 */
	public function getIncomeByMonth($month) {
		$firstday = mktime ( 0, 0, 0, $month, 1, date ( 'Y' ) );
		$lastday = strtotime ( "+1 month", $firstday );
		$data = UserIncomeLogModel::model ()->find ( array (
				'select' => 'sum(amount) as amount',
				'condition' => 'user_id=' . $this->userId . ' AND operator_time>=' . $firstday . ' AND operator_time<=' . $lastday . ' AND type = 1 ',
				'group' => 'user_id' 
		) );
		return $data->amount ? $data->amount : 0;
	}
	/**
	 * 根据天数获取收入
	 *
	 * @param string $day
	 *        	天数
	 * @param integer $type
	 *        	1:应用试用2:好友分成
	 *        	
	 * @return integer
	 */
	public function getIncomeByDay($day, $type = 1) {
		$firstday = mktime ( 0, 0, 0, date ( 'm' ), date ( 'd' ) - 1, date ( 'Y' ) );
		$lastday = strtotime ( "+$day day", $firstday );
		$where = $type ? '`action` = 1' : '`action` IN(3, 4)';
		$data = UserIncomeLogModel::model ()->find ( array (
				'select' => 'sum(amount) as amount',
				'condition' => "user_id=" . $this->userId . " AND operator_time>=" . $firstday . " AND operator_time<=" . $lastday . " AND {$where} AND type = 1 ",
				'group' => 'user_id' 
		) );
		return $data->amount ? $data->amount : 0;
	}
	/**
	 * 　获取好友分成
	 */
	public function getFriendsAmount() {
		$data = UserIncomeLogModel::model ()->find ( [ 
				'select' => 'sum(amount) as amount',
				'condition' => "user_id=" . $this->userId . " AND `action` IN(3, 4) AND type = 1",
				'group' => 'user_id' 
		] );
		return $data->amount ? $data->amount : 0;
	}
	/**
	 * 获取应用收入总金额
	 */
	public function getAppTotalAmount() {
		$data = UserIncomeLogModel::model ()->find ( [
				'select' => 'sum(amount) as amount',
				'condition' => "user_id=" . $this->userId . " AND `action` = 1 AND type = 1",
				'group' => 'user_id'
				] );
		return $data->amount ? $data->amount : 0;
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