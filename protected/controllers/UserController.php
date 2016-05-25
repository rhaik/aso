<?php
/**
 * 
 * 用户管理
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class UserController extends Controller {
	/**
	 * (non-PHPdoc)
	 *
	 * @see CController::filters()
	 */
	public function filters() {
		return array (
				array (
						'TokenFilter + Index,EnchashmentList',
						'action' => 'user.Login' 
				),
				array (
						'RequestFilter + Create' 
				)
		);
	}
	
	/**
	 * 查看用户信息
	 */
	public function actionIndex() {
		$this->renderJSON ( array (
				'data' => CacheM::get ( 'User', $this->getUserId() ) 
		) );
	}
	/**
	 * 创建用户信息并登录
	 */
	public function actionCreate() {
		$component = Yii::app ()->getComponent ( 'requestFilter' );
		
		$openid = trim ( $component->paramsData ['openid'] );
		$userArray = CacheM::get ( 'UserOpenId', $openid );
		
		if (empty ( $userArray )) {
			$user = new UserModel ();
			$user->avatar = trim ( $component->paramsData ['avatar'] );
			$user->name = trim ( $component->paramsData ['name'] );
			$user->openid = $openid;
			$user->area = trim ( $component->paramsData ['area'] );
			$user->appleid = trim ( $component->paramsData ['appleid'] );
			$user->registration_time = time ();
			$user->amount = 0;
			$user->save ();
			$errors = $user->getErrors ();
			if (is_array ( $errors ) && count ( $errors )) {
				foreach ( $errors as $e ) {
					$errorMessager [] = $e [0];
				}
				
				$this->renderJSON ( [ 
						'type' => 'error',
						'success' => false,
						'message' => implode ( ',', $errorMessager ),
						'errorCode' => ExceptionStatus::CODE_VALIDATE_ERROR 
				] );
			}
		}
		$userArray ['token'] = Yii::app ()->token->create ( 'user.login', [ 
				'user_id' => $userArray ['id'],
				'openid' => $userArray ['openid'] 
		] );
		$userArray ['tokenExpire'] = time () + Yii::app ()->token->getExpire ();
		
		unset($userArray['id']);
		$this->renderJSON ( [ 
				'data' => $userArray 
		] );
	}
	/**
	 * 刷新token
	 */
	public function actionRefreshToken() {
		$openid = $this->request->getParam ( 'openid' );
		$userArray = CacheM::get ( 'UserOpenId', $openid );
		if (empty ( $userArray )) {
			throw new CHttpException ( HttpStatus::CODE_OK, 'OpenID不存在，登录失败', 401 );
		} else {
			$userArray ['token'] = Yii::app ()->token->create ( 'user.login', [ 
					'user_id' => $userArray ['id'],
					'openid' => $userArray ['openid'] 
			] );
			$userArray ['tokenExpire'] = time () + Yii::app ()->token->getExpire ();
			
			unset($userArray['id']);
			$this->renderJSON ( [ 
					'data' => $userArray 
			] );
		}
	}
}