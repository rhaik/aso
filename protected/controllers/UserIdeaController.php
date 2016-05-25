<?php
/**
 * 
 * 用户意见反溃
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class UserIdeaController extends Controller {
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
	 * 提交反溃信息
	 */
	public function actionCreate() {
		$component = Yii::app ()->getComponent ( 'requestFilter' );
		$validate = empty ( $component->paramsData ) || empty ( $component->paramsData ['content'] ) || empty ( $component->paramsData ['version'] ) || empty ( $component->paramsData ['equipment'] );
		if (! $validate) {
			$idea = new UserIdeaModel ();
			$idea->user_id = $this->getUserId();
			$idea->content = $component->paramsData ['content'];
			$idea->version = $component->paramsData ['version'];
			$idea->equipment = $component->paramsData ['equipment'];
			$idea->create_time = time ();
			$this->renderJSON ( [ 
					'success' => $idea->save () 
			] );
		} else {
			throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_LACK_ERROE );
		}
	}
}