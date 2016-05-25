<?php
/**
 * 
 * 消息管理
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class MessageController extends Controller {
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
	 * 消息
	 */
	public function actionIndex() {
		$this->renderJSON ( [ 
				'data' => CacheM::get ( 'Message', $this->getUserId() ) 
		] );
	}
	/**
	 * 应用消息列表
	 *
	 * @param string $token
	 *        	用户唯一标识
	 * @param integer $pageon
	 *        	　当前页
	 */
	public function actionApp() {
		$pageOn = intval ( $this->request->getParam ( 'pageon' ) );
		$pageOn = $pageOn > 0 ? $pageOn : 1;
		
		$key = $this->getUserId() . '_1_' . $pageOn;
		$this->renderJSON ( [ 
				'data' => CacheM::get ( 'MessageList', $key ) 
		] );
	}
	/**
	 * 好友消息列表
	 *
	 * @param string $token
	 *        	用户唯一标识
	 * @param integer $pageon
	 *        	　当前页
	 */
	public function actionFriend() {
		$pageOn = intval ( $this->request->getParam ( 'pageon' ) );
		$pageOn = $pageOn > 0 ? $pageOn : 1;
		
		$key = $this->getUserId() . '_2_' . $pageOn;
		$this->renderJSON ( [ 
				'data' => CacheM::get ( 'MessageList', $key ) 
		] );
	}
	/**
	 * 系统消息
	 *
	 * @param string $token
	 *        	用户唯一标识
	 * @param integer $pageon
	 *        	　当前页
	 */
	public function actionSystem() {
		$pageOn = intval ( $this->request->getParam ( 'pageon' ) );
		$pageOn = $pageOn > 0 ? $pageOn : 1;
		$key = $this->getUserId() . '_' . $pageOn;
		$this->renderJSON ( [ 
				'data' => CacheM::get ( 'SystemMessageList', $key ) 
		] );
	}
	/**
	 * 更新已读状态
	 */
	public function actionUpdate() {
		$tokenData = $this->cache->get ( 'USER_' . trim ( $this->request->getPut ( 'token' ) ) );
		$id = intval ( $this->request->getQuery ( 'id' ) );
		if ($id <= 0) {
			throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_LACK_PARAMS );
		}
		$type = $this->request->getPut ( 'type' );
		if ($type != 'system') {
			$message = new UserAppNoticeModel ();
		} else {
			$message = new UserNoticeModel ();
		}
		$message->updateByPk ( $id, [ 
				'is_read' => 1 
		], 'user_id=' . $this->getUserId () );
		
		// 更新缓存
		CacheM::set ( 'Message', $this->getUserId () );
		$this->renderJSON ();
	}
}