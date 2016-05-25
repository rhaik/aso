<?php
/**
 * 
 * @author zhanghaisong
 *
 */
class TokenFilter extends CFilter {
	/**
	 * @var string Name of the application component
	 */
	public $component = 'token';
	/**
	 * @var string Name of request parameter which contains token string
	 */
	public $tokenName = 'token';
	/**
	 * @var null|integer|float Current time as timestamp. $_SERVER['REQUEST_TIME'] used if NULL.
	 */
	public $time = null;
	/**
	 * @var string
	 */
	public $action = 'user.Login';
	/**
	 * @var string Custom message for CHttpException
	 */
	public $message = '验证token失败';

	/**
	 * Performs token validation.
	 *
	 * @param CFilterChain $filterChain the filter chain that the filter is on.
	 * @return boolean whether the filtering process should continue and the action should be executed.
	 * May also throws CHttpException depending on {@see $throwException} option.
	 * @throws CHttpException
	 */
	protected function preFilter($filterChain) {
		if (Yii::app ()->request->isPutRequest) {
			$token = Yii::app ()->request->getPut ( $this->tokenName );
		} else if (Yii::app ()->request->isDeleteRequest) {
			$token = Yii::app ()->request->getDelete ( $this->tokenName );
		} else {
			$token = Yii::app ()->request->getParam ( $this->tokenName );
		}
		if (empty ( $token )) {
			throw new CHttpException ( 400, '缺少TOKEN参数', 400 );
		}
		
		$component = Yii::app ()->getComponent ( $this->component );
		if ($component->validateToken ( $token, $this->action )) {
			/* token valid an not expired */
			return true;
		}
		throw new CHttpException ( 400, $this->message,  400);
	}
}
