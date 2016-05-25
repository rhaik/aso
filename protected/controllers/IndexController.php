<?php
/**
 * 
 * 用户管理
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class IndexController extends Controller {
	
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
	 * 首页
	 */
	public function actionIndex() {
		$this->title = '首页';
		$this->render ( 'index', array (
				'data' => CacheM::get ( 'UserStatistics', $this->getUserId () ) 
		) );
	}
	/**
	 * 首页返回JSON数据
	 */
	public function actionIndexJson() {
		$this->renderJSON ( [ 
				'data' => CacheM::get ( 'UserStatistics', $this->getUserId () ) 
		] );
	}
	/**
	 * 测试页面
	 */
	public function actionTest() {
		$this->title = '测试页面';
		$this->render ( 'test', [ 
				'token' => Yii::app()->token->getToken()
		] );
	}
}