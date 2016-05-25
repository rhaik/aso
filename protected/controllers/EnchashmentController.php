<?php
/**
 *
* 提现管理
*
* @author zhanghaisong 2014-1-7
*
*/
class EnchashmentController extends Controller {
	/**
	 *
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
				),
				array (
						'RequestFilter + Create'
				)
		);
	}
	/**
	 * 提现列表页面
	 */
	public function actionIndex() {
		$this->title = '提现列表';
		$this->render ( 'index', [ 
				'data' => CacheM::get ( 'UserEnchashmentList', $this->getUserId () ),
				'token' => Yii::app()->token->getToken() 
		] );
	}
	/**
	 * 提现页面
	 */
	public function actionPage() {
		$this->title = '提现';
		$this->render ( 'page', [ 
				'user' => CacheM::get ( 'User', $this->getUserId () ),
				'token' => Yii::app()->token->getToken(),
				'form' =>  new UserEnchashmentModel ()
		] );
	}
	/**
	 * 提现
	 */
	public function actionCreate() {
		$this->title = '提现';
		$component = Yii::app ()->getComponent ( 'requestFilter' );
		$model = new UserEnchashmentModel ();
		$model->user_id = $this->getUserId ();
		$model->account = trim ( $component->paramsData ['account'] );
		$model->account_name = trim ( $component->paramsData ['account_name'] );
		$model->amount = $component->paramsData ['amount'];
		$model->times = time ();
		$model->status = 1;
		if ($model->save ()) {
			CacheM::set ( 'UserEnchashmentList', $this->getUserId () );
			$this->redirect ( '/Enchashment/?token=' . Yii::app()->token->getToken() );
		} else {
			$this->render ( 'page', [ 
					'user' => CacheM::get ( 'User', $this->getUserId () ),
					'token' => Yii::app()->token->getToken(),
					'form' => $model 
			] );
		}
	}
}