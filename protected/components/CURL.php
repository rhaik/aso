<?php
/**
 * 
 * CURL方法
 * @author zhanghaisong
 *
 */
class CURL {
	/**
	 * 可以使用https请求，参数为url和param。
	 *
	 * @param strval $url
	 *        	url
	 * @param
	 *        	array [$param] 请求的参数[可选]
	 * @return array(result,[http_code])
	 */
	public static function post($url = '', array $param = array(), array $options = array()) {
		if (! empty ( $url )) {
			$options = array (
					CURLOPT_POST => 1,
					CURLOPT_HEADER => 0,
					CURLOPT_URL => $url,
					CURLOPT_FRESH_CONNECT => 1,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_FORBID_REUSE => 1,
					CURLOPT_TIMEOUT => 1 
			);
			if (! empty ( $param ) && is_array ( $param )) {
				$options [CURLOPT_POSTFIELDS] = http_build_query ( $param );
			}
			if (substr ( $url, 0, 5 ) == 'https') {
				$options [CURLOPT_SSL_VERIFYPEER] = FALSE;
				$options [CURLOPT_SSL_VERIFYHOST] = FALSE;
			}
			
			$ch = curl_init ();
			curl_setopt_array ( $ch, $options );
			$result = curl_exec ( $ch );
			$info = curl_getinfo ( $ch );
			curl_close ( $ch );
			return $result;
		} else {
			return false;
		}
	}
	/**
	 * get请求
	 *
	 * @param string $url        	
	 * @param array $param        	
	 *
	 * @return string
	 */
	public static function get($url, array $param = array()) {
		if (! empty ( $param ) && is_array ( $param )) {
			$url .= '?' . http_build_query ( $param );
		}
		
		$ch = curl_init ();
		// 2. 设置选项，包括URL
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
		
		// 3. 执行并获取HTML文档内容
		$info = curl_exec ( $ch );
		
		$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		
		// 4. 释放curl句柄
		curl_close ( $ch );
		return array (
				'status' => $httpCode,
				'data' => $info 
		);
	}
}