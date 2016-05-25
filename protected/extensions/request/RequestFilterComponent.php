<?php
/**
 * 
 * 数据加密验证组件
 * 
 * @author zhanghaisong
 *
 */
class RequestFilterComponent extends CApplicationComponent {
	/**
	 *
	 * @var int Token life time in seconds. Default value is 1 day.
	 */
	public $duration = 86400;
	/**
	 *
	 * @var null string encryption key to pass to {@link CSecurityManager::encrypt}
	 */
	public $encryptionKey = null;
	/**
	 * 验证数据
	 *
	 * @var array
	 */
	public $paramsData = array ();
	/**
	 * 是否开启加密
	 * 
	 * @var boolean
	 */
	public $disabled = true;
	
	/**
	 * 验证数据是否正确
	 *
	 * @param string $data        	
	 * @throws CHttpException
	 * @return Ambigous <boolean, mixed>|boolean
	 */
	public function validate($data) {
		if (is_array ( $data ) && $this->disabled) {
			$this->paramsData = $data;
			$data = serialize ( $data );
		} else {
			$this->paramsData = $this->decodeData ( $data );
		}
		if (! empty ( $this->paramsData )) {
			$key = md5 ( $data );
			$cache = Yii::app ()->getCache ();
			/*
			 * if ($cache->get ( $key )) { throw new CHttpException ( HttpStatus::CODE_OK, '重复请求', 1001 ); }
			 */
			
			$cache->set ( $key, 1, $this->duration );
			return $this->paramsData;
		}
		return false;
	}
	
	/**
	 * 生成加密参数数据
	 *
	 * @param array $params        	
	 *
	 * @return string
	 */
	public function create(array $params) {
		return $this->escapeData ( DESManager::encrypt ( serialize ( $params ), $this->encryptionKey ) );
	}
	
	/**
	 *
	 * @param string $data        	
	 * @return bool array
	 */
	protected function decodeData($data) {
		$data = $this->unescapeData ( $data );
		$paramsData = unserialize ( DESManager::decrypt ( $data, $this->encryptionKey ) );
		if (! $paramsData || ! is_array ( $paramsData )) {
			return false;
		}
		return $paramsData;
	}
	
	/**
	 * Replace some characters to maximize url compatibility.
	 *
	 * @param string $data
	 *        	Un-escaped token as binary string.
	 * @return string Escaped $data.
	 */
	protected function escapeData($data) {
		return str_replace ( array (
				'+',
				'/',
				'=' 
		), array (
				'_',
				'-',
				'' 
		), base64_encode ( $data ) );
	}
	
	/**
	 * Replaces characters, previously replaced by {@link TimeBarredTokenComponent::escapeToken}.
	 *
	 * @param string $data        	
	 * @return string Un-escaped $data as binary string, ready to decoding
	 */
	protected function unescapeData($data) {
		return base64_decode ( str_replace ( array (
				'_',
				'-' 
		), array (
				'+',
				'/' 
		), $data ) );
	}
}
