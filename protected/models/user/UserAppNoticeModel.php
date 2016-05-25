<?php
/**
 * 
 * @author zhanghaisong
 * 
 * 用户消息通知模型
 *
 */
class UserAppNoticeModel extends ActiveRecord {
	public $appId, $appName, $appIcon, $taskName, $taskStartTime, $taskAction, $taskId, $finishTime,$taskAmount, $taskFriendsAmount;
	
	const ACTION_FINISH = 1; // 完成试用
	const ACTION_SHARE = 2; // 分享
	const ACTION_INVITE_FRIENDS = 3; // 邀请好友　
	const ACTION_FRIENDS = 4;			//好友分成
	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @return CActiveRecord the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'money_user_app_notice';
	}
	/**
	 * 获取动作状态
	 *
	 * @return multitype:number
	 */
	public static function getActionArray() {
		return [1,2,3,4];
	}
}