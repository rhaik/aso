<?php
/**
 * 
 * 分享
 * @author zhanghaisong
 *
 */
class Share {
	/**
	 * 
	 * 头像
	 * 
	 * @var string
	 */
	private $avatar;
	public function __construct($avatar) {
		$this->avatar = $avatar;
	}
	/**
	 * 获取字体文件地址
	 *
	 * @return string
	 */
	public function getFontPath() {
		return Yii::app ()->basePath . '/data/msyhl.ttc';
	}
	/**
	 * 获取水印背景图片地址
	 *
	 * @return string
	 */
	public function getRadiusImagePath() {
		return Yii::app ()->basePath . '/../www/assets/images/corner.png';
	}
	/**
	 * 获取背景图片地址
	 *
	 * @return string
	 */
	public function getBackgroundImagePath() {
		return Yii::app ()->basePath . '/../www/assets/images/share_02.png';
	}
	/**
	 * 获取头像下载地址
	 *
	 * @return string
	 */
	public function getAvatarPath() {
		return Yii::app ()->params ['avatar'] ['path'] . $this->getDir () . $this->getFullFileName ();
	}
	/**
	 * 获取分享头像缩略图
	 *
	 * @return string
	 */
	public function getShareAvatarThumbPath() {
		return Yii::app ()->params ['share']['path'] . $this->getDir () . $this->getFileName () . '_thumb.jpg';
	}
	/**
	 * 获取分享图片地址
	 *
	 * @return string
	 */
	public function getShareImageUrl() {
		return Yii::app ()->params ['share'] ['url'] . $this->getDir () . $this->getFullFileName ();
	}
	/**
	 * 获取分享图片路径
	 *
	 * @return string
	 */
	public function getShareImagePath() {
		return Yii::app ()->params ['share'] ['path'] . $this->getDir () . $this->getFullFileName ();
	}
	/**
	 *
	 * 获取目录
	 *
	 * @return string
	 */
	public function getDir() {
		return substr ( $this->getFileName (), 0, 2 ) . '/';
	}
	/**
	 * 获取分享图片文件名
	 *
	 * @return string
	 */
	public function getFileName() {
		return md5 ( $this->avatar );
	}
	/**
	 * 获取分享图片文件全名
	 *
	 * @return string
	 */
	public function getFullFileName() {
		return md5 ( $this->avatar ) . '.jpg';
	}
}