<?php
/**
 * 
 * 异常处理类
 * @author zhanghaisong
 *
 */
class HttpException extends CHttpException {
	public function __construct($status, $code = 0, $message = null) {
		$msg = new ExceptionStatus($code, $message);
		parent::__construct ($status, $msg->getMessage(), $code );
	}
}