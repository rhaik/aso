<?php
/**
 * 
 * 异常状态
 * 
 * @author zhanghaisong
 *
 */
class ExceptionStatus {

	const CODE_MQ_MESSAGE = 1000;
	const CODE_LACK_PARAMS = 1001;
	const CODE_TASK_EXIST = 4004;
	const CODE_LACK_ERROE = 1002;
	const CODE_VALIDATE_ERROR = 1003;
	/**
	 * @var array All the http status messages.
	 */
	public static $messages = [
		ExceptionStatus::CODE_MQ_MESSAGE => '消息入队失败',
		ExceptionStatus::CODE_LACK_PARAMS=> '缺少参数ID',
		ExceptionStatus::CODE_TASK_EXIST => '任务不存在',
		ExceptionStatus::CODE_LACK_ERROE => '参数错误,非法请求!',
	];

	/**
	 * @var int The http status code.
	 */
	public $code;

	/**
	 * @var string The http status message.
	 */
	public $message;

	/**
	 * @param int $code The Http status code. [optional]
	 */
	public function __construct($code, $message = null)
	{
		$this->set($code, $message);
	}

	public function set($code, $message = null)
	{
		if ($message === null && isset(self::$messages[$code])) {
			$message = self::$messages[$code];
		}
		$this->code = $code;
		$this->message = $message;

		return $this;
	}
 
	/**
	 * @return string The Message
	 */
	public function getMessage() 
	{
		return $this->message;
	}

}
