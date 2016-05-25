<?php
/**
 * 
 * 分享图片生成
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class ShareController extends Controller {
	/**
	 *
	 * @var string
	 */
	public $layout = false;
	/**
	 * (non-PHPdoc)
	 *
	 * @see CController::filters()
	 */
	public function filters() {
		return array (
				array (
						'TokenFilter' 
				) 
		);
	}
	
	/**
	 * 生成分享图片
	 */
	public function actionIndex() {
		ini_set ( 'memory_limit', '512M' );
		
		$user = CacheM::get ( 'UserStatistics', $this->getUserId () );
		$avatarUrl = $user ['avatar'];
		
		$share = new Share ( $user ['avatar'] );
		
		$remoteImage = new RemoteDownloadImage ( $avatarUrl );
		$remoteImage->Save ( $share->getAvatarPath () );
		
		$t = new ThumbHandler ();
		$t->setSrcImg ( $share->getAvatarPath() );
		$t->resize ( 120, 120 );
		$t->radius ( $share->getRadiusImagePath () );
		$t->setDstImg ( $share->getShareAvatarThumbPath () );
		$t->createImg ();
		
		$t = new ThumbHandler ();
		$t->setSrcImg ( $share->getBackgroundImagePath () );
		$t->setMaskImg ( $share->getShareAvatarThumbPath () );
		$t->setMaskPosition ( 5 );
		$t->setImgDisplayQuality ( 9 );
		$t->setMaskImgPct ( 100 );
		$t->setMaskOffsetX ( 0 );
		$t->setMaskOffsetY ( 12 );
		$t->resize ( 750, 1000 );
		$image = $t->getImageResource ();
		
		$color = imagecolorallocate ( $image, 255, 255, 255 ); // 设置一个颜色变量为黑色
		$color1 = imagecolorallocate ( $image, 255, 0, 0 ); // 设置一个颜色变量为黑色
		$width = imagesx ( $image );
		$fontfile = $share->getFontPath ();
		imagettftext ( $image, 25, 0, $width / 2 - strlen ( $user ['name'] ) * 6, 200, $color, $fontfile, $user ['name'] );
		imagettftext ( $image, 25, 0, $width - (strlen ( $user ['registerDay'] ) * 14 + 120), 320, $color1, $fontfile, $user ['registerDay'] );
		imagettftext ( $image, 25, 0, $width - (strlen ( $user ['amount'] ) * 14 + 120), 410, $color1, $fontfile, $user ['amount'] );
		imagettftext ( $image, 25, 0, $width - (strlen ( $user ['userFriends'] ) * 14 + 120), 506, $color1, $fontfile, $user ['userFriends'] );
		imagettftext ( $image, 25, 0, $width - (strlen ( $user ['userFriendsAmount'] ) * 14 + 120), 588, $color1, $fontfile, $user ['userFriendsAmount'] );
		
		$t->setImageResource ( $image );
		$t->setDstImg ( $share->getShareImagePath () );
		$t->createImg ();
		
		$this->renderJSON ( [ 
				'data' => [ 
						'url' => $share->getShareImageUrl () 
				] 
		] );
	}
}
