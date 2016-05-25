<?php
/**
 * 
 * 排行管理
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class RankController extends Controller {
	/**
	 * @var string
	 */
	public $layout = '//layout/main';
	/**
	 * (non-PHPdoc)
	 *
	 * @see CController::filters()
	 */
	public function filters() {
		return array (
				array (
						'TokenFilter' 
				) 
		);
	}
	
	/**
	 * 总排行
	 */
	public function actionIndex() {
		$this->title = '排行榜';
		$this->render ( 'index', [ 
				'monthData' => CacheM::get ( 'IncomeRank', 'month' ),
				'totalData' => CacheM::get ( 'IncomeRank', 'total' ),
				'user' => CacheM::get ( 'UserStatistics', $this->getUserId () ),
				'token' => Yii::app()->token->getToken() 
		] );
	}
	/**
	 * 分享页面
	 */
	public function actionShare() {
		$this->title = '我的收入';
		$user = CacheM::get ( 'UserStatistics', $this->getUserId () );
		$share = new Share ( $user ['avatar'] );
		$this->render ( 'share', [ 
				'user' => $user,
				'token' => Yii::app()->token->getToken(),
				'url' => $share->getShareImageUrl () 
		] );
	}
}