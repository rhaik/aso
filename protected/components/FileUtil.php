<?php
/**
 * 
 * 文件操作类
 *
 * @author zhanghaisong 2014-3-20
 *
 */

class FileUtil {
	/**
	 * 
	 * 建立文件夹,$aimUrl=文件夹路径+文件夹名称
	 *
	 * @param string $aimUrl	目录
	 *
	 * @return  boolean
	 */
	public static function createDir($aimUrl) {
		$aimUrl = str_replace ( '', '/', $aimUrl );
		$aimDir = '';
		$arr = explode ( '/', $aimUrl );
		$arr = array_diff ( $arr, array () );
		foreach ( $arr as $str ) {
			$aimDir .= $str . '/';
			if (! file_exists ( $aimDir )) {
				mkdir ( $aimDir );
			}
		}
		return true;
	}
	
	/**
	 * 
	 * 建立文件 $overWrite=是否覆盖已存在的文件,ture为覆盖,false不覆盖
	 *
	 * @param string $aimUrl	文件路径
	 * @param boolean $overWrite	是否覆盖
	 *
	 * @return  boolean
	 */
	
	function createFile($aimUrl, $overWrite = false) {
		if (file_exists ( $aimUrl ) && $overWrite == false) {
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite == true) {
			FileUtil::unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		FileUtil::createDir ( $aimDir ); //FileUtil::等同于$this->
		touch ( $aimUrl );
		return true;
	}
}
