<?php
@set_time_limit ( 10 * 60 ); // 限制最大的执行时间
/**
 *
 *
 *
 * 远程下载图片类
 *
 * @author zhanghaisong
 *        
 */
class RemoteDownloadImage {
	/**
	 * 远程下载地址
	 *
	 * @var string
	 */
	private $url;
	/**
	 * 图片地址
	 *
	 * @var string
	 */
	private $imagePath;
	public function __construct($url) {
		$this->url = $url;
		if (empty ( $this->url )) {
			throw new CHttpException ( '200', '缺少URL地址' );
		}
	}
	/**
	 * 保存图片
	 *
	 * @param string $fileName
	 *        	文件名
	 */
	public function Save($fileName = '') {
		FileUtil::createDir ( dirname ( $fileName ) );
		
		$hander = curl_init ();
		$fp = fopen ( $fileName, 'wb' );
		curl_setopt ( $hander, CURLOPT_URL, $this->url );
		curl_setopt ( $hander, CURLOPT_FILE, $fp );
		curl_setopt ( $hander, CURLOPT_HEADER, 0 );
		curl_setopt ( $hander, CURLOPT_FOLLOWLOCATION, 1 );
		// curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
		curl_setopt ( $hander, CURLOPT_TIMEOUT, 60 );
		
		curl_exec ( $hander );
		curl_close ( $hander );
		fclose ( $fp );
	}
}