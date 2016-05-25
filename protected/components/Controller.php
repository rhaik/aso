<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $title = '';
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='json';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	/**
	 * 
	 * 请求对像
	 *
	 * @var CHttpRequest
	 */
	public $request = null;
	/**
	 * 
	 * 缓存对像
	 *
	 * @var CMemCache
	 */
	public $cache = null; 
	/**
	 * 重新init方法
	 * @see CController::init()
	 */
	public function init() {
		$this->request = Yii::app ()->getRequest ();
		$this->cache = Yii::app ()->getCache ();
		
		return true;
	}
	/**
	 *
	 * @return Ambigous <>
	 */
	public function getUserId() {
		$tokenData = $this->cache->get ( 'USER_' . Yii::app()->token->getToken() );
		return $tokenData ['user_id'];
	}
	/**
	 * renderJSON
	 *
	 * helper function for rendering json
	 *
	 * @param
	 *        	(Array) (params) list of params to send to the render
	 */
	public function renderJSON($params = array()) {
		$this->render ( 'ext.restfull.views.api.output', array_merge ( array (
				'type' => 'rest',
				'code' => 200,
				'message' => 'OK',
		), $params ) );
		exit;
	}
}