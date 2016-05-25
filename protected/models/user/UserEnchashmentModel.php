<?php
/**
 * 
 * @author zhanghaisong
 * 
 * 用户提现
 *
 */
class UserEnchashmentModel extends ActiveRecord {
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
		return 'money_user_enchashment';
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see CModel::rules()
	 */
	public function rules() {
		return array (
				array (
						'account_name',
						'required',
						'message' => '提现名称不能为空' 
				),
				array (
						'account',
						'required',
						'message' => '提现账号不能为空' 
				),
				array (
						'amount',
						'numerical',
						'message' => '金额必须在0-10000之间',
						'min' => 1,
						'max' => 10000 
				) 
		);
	}
}