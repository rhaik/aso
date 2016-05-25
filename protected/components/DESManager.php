<?php
/**
 *
* 数据加密解密类
* 
* @author zhanghaisong
*
*/
class DESManager {
	/**
	 *
	 * @param string $encrypt        	
	 * @param string $key        	
	 *
	 * @return string
	 */
	public static function encrypt($encrypt, $key) {
		$block = mcrypt_get_block_size ( MCRYPT_DES, MCRYPT_MODE_ECB );
		$pad = $block - (strlen ( $encrypt ) % $block);
		$encrypt .= str_repeat ( chr ( $pad ), $pad );
		$passcrypt = mcrypt_encrypt ( MCRYPT_DES, $key, $encrypt, MCRYPT_MODE_ECB );
		return  $passcrypt;
	}
	
	/**
	 * PHP DES 解密
	 *
	 * @param $decrypt 密文      
	 * @param $key 密钥        	
	 *
	 * @return string 明文
	 */
	public static function decrypt($decrypt, $key) {
		$str = mcrypt_decrypt ( MCRYPT_DES, $key,  $decrypt, MCRYPT_MODE_ECB );
		
		$pad = ord ( $str [strlen ( $str ) - 1] );
		return substr ( $str, 0, strlen ( $str ) - $pad );
	}
}
