<?php
/**
 * 
 * 
 * @author zhanghaisong
 *
 */
class TokenModel extends ActiveRecord
{

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
		return 'money_token';
	}
	/**
	 * (non-PHPdoc)
	 * @see CModel::rules()
	 */
    public function rules()
    {
        return array(
        array('action', 'match', 'pattern'=>'/^([a-zA-Z0-9]+\.)*[a-zA-Z0-9]+$/'),
        array('identity', 'match', 'pattern'=>'/^[a-z0-9]{32}$/'),
        array('token', 'match', 'pattern'=>'/^[a-z0-9]{32}$/'),
        array('user_id', 'required', 'message' => 'USERID不能为空'),
        array('expire_time', 'match', 'pattern'=>'/^[0-9]+$/')
        );
    }
    /**
     * 保存之前将令牌里保存的值序列化
     * @return boolean
     */
    public function beforeSave()
    {
    	if (parent::beforeSave())
    		$this->data = serialize($this->data);
    	return true;
    }
    
    /**
     * 读取记录之后，恢复里面存储的值为原始格式
     */
    public function afterFind()
    {
    	$this->data = unserialize($this->data);
    }
}