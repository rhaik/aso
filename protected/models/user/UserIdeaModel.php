<?php
/**
 * 
 * @author zhanghaisong
 * 
 * 用户意见反溃模型
 *
 */
class UserIdeaModel extends ActiveRecord {
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
		return 'money_user_idea';
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see CModel::rules()
	 */
	public function rules() {
		return array (
				array (
						'content',
						'required',
						'message' => '反溃内容不能为空' 
				),
				array (
						'version',
						'required',
						'message' => '客户端版本号不能为空' 
				),
				array (
						'equipment',
						'required',
						'message' => '设备号不能为空' 
				) 
		);
	}
}