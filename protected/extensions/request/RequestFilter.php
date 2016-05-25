<?php
/**
 * 
 * 请求数据过滤
 * 
 * @author zhanghaisong
 *
 */
class RequestFilter extends CFilter {
	/**
	 * @var string Name of the application component
	 */
	public $component = 'requestFilter';
	/**
	 * @var string Name of request parameter which contains token string
	 */
	public $paramsName = 'data';
	/**
	 * @var string Custom message for CHttpException
	 */
	public $message = '数据不对,非法请求';

	/**
	 * (non-PHPdoc)
	 * @see CFilter::preFilter()
	 */
	protected function preFilter($filterChain) {
		if (Yii::app ()->request->isPutRequest) {
			$data = Yii::app ()->request->getPut ( $this->paramsName );
		} else if (Yii::app ()->request->isDeleteRequest) {
			$data = Yii::app ()->request->getDelete ( $this->paramsName );
		} else {
			$data = Yii::app ()->request->getParam ( $this->paramsName );
		}
		if (empty ( $data )) {
			throw new HttpException ( HttpStatus::CODE_OK, ExceptionStatus::CODE_LACK_PARAMS );
		}
		$component = Yii::app()->getComponent($this->component);
		
		if ($component->validate ( $data )) {
			return true;
		}
		throw new CHttpException ( HttpStatus::CODE_OK, $this->message, 400 );
	}
}
