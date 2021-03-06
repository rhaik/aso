<?php
/**
 * 
 * @author zhanghaisong
 * 
 * 用户好友模型
 *
 */
class UserInvitationFriendsModel extends ActiveRecord {
	public $userName,$friendName,$friendAvatar;
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
		return 'money_user_invitation_friends';
	}
}