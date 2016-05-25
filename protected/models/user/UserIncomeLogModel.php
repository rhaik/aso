<?php
/**
 * 
 * @author zhanghaisong
 * 
 * 用户收支明细模型
 *
 */
class UserIncomeLogModel extends ActiveRecord {
	const ACTION_FINISH = 1;			//完成试用
	const ACTION_SHARE = 2;				//分享
	const ACTION_INVITE_FRIENDS = 3;	//邀请好友
	const ACTION_FRIENDS = 4;			//好友分成
	const ACTION_WITHDRAW = 5;			//提现
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
		return 'money_user_income_log';
	}
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::relations()
	 */
	public function relations() {
		return array (
				'user' => array (
						self::BELONGS_TO,
						'UserModel',
						'user_id'
				)
		);
	}
	/**
	 * 获取动作状态
	 * 
	 * @return multitype:number
	 */
	public static function getActionArray() {
		return [1,2,3,4,5];
	}
	
}