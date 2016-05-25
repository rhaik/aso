<?php
/**
 * 
 * @author zhanghaisong
 * 
 * 用户任务模型
 *
 */
class UserTaskModel extends ActiveRecord {
	const ACTION_FINISH = 1; // 未试用
	const ACTION_UNFINISHED = 2; // 完成试用
	const ACTION_EXPIRED = 3;			//过期

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
		return 'money_user_task';
	}
}