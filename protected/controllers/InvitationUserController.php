<?php
/**
 * 
 * 用户邀请管理
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class InvitationUserController extends Controller {
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
	 * 邀请列表
	 */
	public function actionIndex() {
		$this->title = '邀请记录列表';
		$this->layout = '//layout/main';
		$this->render ( 'index', [ 
				'data' => CacheM::get ( 'FriendList', $this->getUserId () ) 
		] );
	}
	/**
	 * 用户邀请好友
	 */
	public function actionCreate() {
		$tokenData = $this->cache->get ( 'USER_' . trim ( $this->request->getParam ( 'token' ) ) );
		$component = Yii::app ()->getComponent ( 'requestFilter' );
		
		if (! empty ( $component->paramsData ) && intval ( $component->paramsData ['friends'] ) > 0) {
			$user = UserModel::model ()->findByPk ( $component->paramsData ['friends'] );
			if (empty ( $user )) {
				throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_LACK_ERROE );
			}
			$friendModel = UserInvitationFriendsModel::model ()->findByAttributes ( [ 
					'user_id' => $this->getUserId(),
					'friends' => $component->paramsData ['friends'] 
			] );
			if (empty ( $friendModel )) {
				$friend = new UserInvitationFriendsModel ();
				$friend->user_id = $this->getUserId();
				$friend->friends = $com/Users/zhanghaisong/Documents/workspace/mapi.lieqicun.cn/protected/controllers/RankController.phpponent->paramsData ['friends'];
				$friend->times = time ();
				$this->renderJSON ( [ 
						'success' => $friend->save () && CacheM::set ( 'FriendList', $this->getUserId() ) 
				] );
			} else {
				$this->renderJSON ( [ 
						'success' => true,
						'message' => '用户已经被邀请过了，不能重复' 
				] );
			}
		} else {
			throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_LACK_ERROE );
		}
	}
}