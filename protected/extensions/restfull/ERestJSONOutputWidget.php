<?php
/**
 * ERestJSONOutputWidget
 *
 * Helps in formatting output for rendering JSON on RESTFul Requests=
 *
 * @category   PHP
 * @package    Starship
 * @subpackage Restfullyii/widgets
 * @copyright  Copyright (c) 2013 Evan Frohlich (https://github.com/evan108108)
 * @license    https://github.com/evan108108   OSS
 * @version    Release: 1.2.0
 *
 * @property string		$type
 * @property bool		$success
 * @property string		$message
 * @property array		$data
 * @property integer	$errorCode
 */
class ERestJSONOutputWidget extends CWidget {
	public $type = 'raw';
	public $success = true;
	public $message = "";
	public $data;
	public $errorCode = 500;
	/**
	 * run
	 *
	 * called when widget is to be run
	 * will trigger different output based on $type
	 */
	public function run()
	{
		switch($this->type) {
			case 'error':
				$this->outputError();
				break;
			case 'rest':
				$this->outputRest();
				break;
			default:
				$this->outputRaw();
		}
	}

	/**
	 * outputRaw
	 *
	 * when type is 'raw' this method will simply output $data as JSON
	 */
	public function outputRaw()
	{
		echo CJSON::encode($this->data);
	}

	/**
	 * outputError
	 *
	 * when the output $type is 'error' $data JSON output will be formatted
	 * with a specific error template
	 */ 
	public function outputError()
	{
		echo CJSON::encode([
			'success'	=> false,
			'message'	=> $this->message,
			'data'		=> [
				"errorCode"	=> $this->errorCode,
				"message"	=> $this->message,
			]
		]);
	}

	/**
	 * outputRest
	 *
	 * when $type is 'REST' $data JSON output will be formatted
	 * with a specific rest template
	 */ 
	public function outputRest()
	{
		echo CJSON::encode([
			'success'	=> $this->success,
			'message'	=> $this->message,
			'data'		=> $this->data
		]);
	}
}

