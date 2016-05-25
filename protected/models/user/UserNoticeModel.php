<?php
/**
 * 
 * @author zhanghaisong
 * 
 * 系统消息模型
 *
 */
class UserNoticeModel extends ActiveRecord {
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
		return 'money_user_notice';
	}
}