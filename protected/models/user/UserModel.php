<?php
/**
 * 
 * @author zhanghaisong
 * 
 * 用户管理模型
 *
 */
class UserModel extends ActiveRecord {
	/**
	 * 
	 * 用户TOKEN
	 * 
	 * @var string
	 */
	public $token;
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
		return 'money_user';
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see CModel::rules()
	 */
	public function rules() {
		return array ( 
				array('name','required','message' => '名称不能为空'),
				array('openid','required','message' => 'OPENID不能为空'),
				array('openid','unique','message' => 'OPENID已存在'),
				array('appleid','required','message' => '设备号不能为空'),
				array('area', 'required', 'message' => '地区不能为空'),
				array('avatar', 'url', 'message' => '头像地址不正确')
		);
	}
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave() {
		if (parent::beforeSave())
			$this->user_identity = $this->createUserIdentity();
		return true;
	}
	/**
	 * 创建用户唯一标识
	 * 
	 * @return string
	 */
	public function createUserIdentity() {
		$userIdentity = rand ( 10000000, 99999999 );
		if ($this->countByAttributes ( [ 
				'user_identity' => $userIdentity 
		] )) {
			return $this->createUserIdentity ();
		}
		return $userIdentity;
	}
}