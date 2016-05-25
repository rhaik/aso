<?php
/**
 * 
 * 站点控制品
 *
 * @author zhanghaisong 2014-2-25
 *
 */
class SiteController extends Controller {
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($this->layout == 'json') {
			$error = Yii::app ()->errorHandler->error;
			$error ['type'] = 'error';
			$this->renderJSON ( $error );
		} else {
			if ($error = Yii::app ()->errorHandler->error) {
				if (Yii::app ()->request->isAjaxRequest)
					echo $error ['message'];
				else
					$this->render ( 'error', $error );
			}
		}
	}
}