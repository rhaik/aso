<?php
/**
 * 
 * @author shenxiuying
 * 
 * APP任务管理模型
 * 
 */
class AppTaskModel extends ActiveRecord {
	const ACTION_SEARCH = 1;			//搜索
	const ACTION_DOWNLOAD = 2;			//下载
	const ACTION_BROWSE = 3;			//浏览
	
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
		return 'money_app_task';
	}
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::scopes()
	 */
	public function scopes() {
		return [
			'sort' => [
				'order' => 't.sort ASC,t.id DESC'
			]
		];
	}
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::relations()
	 */
	public function relations() {
		return array (
				'app' => array (
						self::BELONGS_TO,
						'AppModel',
						'app_id' 
				) 
		);
	}
	/**
	 * (non-PHPdoc)
	 * 
	 * @see CModel::rules()
	 */  
	public function rules() {
		return array (##必须和数据库字段相同，必须写规则，才能入库
				array('name','required','message' => '名称不能为空'),
				array('description','required','message' => '描述不能为空'),
				array('description', 'length', 'max'=>500,'tooLong'=>'任务描述在500字以内'),
				array('keywords','required','message' => '搜索关键字不能为空'),
				array('amount','required','message' => '完成奖励积分不能为空'),
				array('amount', 'numerical','message' => '积分必须为数字'),
				array('friends_amount','required','message' => '好友分成积分不能为空'),
				array('friends_amount', 'numerical','message' => '好友分成积分必须为数字'),
				array('start_time','required','message' => '开始时间不能为空或时间格式不正确'),
				array('end_time','required','message' => '结束时间不能为空或时间格式不正确'), 
				array('end_time','check_time')
		);
	}
	
	//检测结束时间必须大于开始时间
	public function check_time(){
			if($this->end_time <= $this->start_time){
					$this->addError('end_time','结束时间必须大于开始时间');
			}
	}
	/**
	 * (non-PHPdoc)
	 * 
	 * @see CModel::attributeLabels()
	 */
	public function attributeLabels() {
		return array (
				'name' => '任务名称',
				'description' => '任务描述',
				'keywords' => '任务搜索关键字',
				'amount' => '任务完成奖励积分',
				'friends_amount' => '好友分成积分',
				'start_time' => '任务开始时间',
				'end_time' => '任务结束时间'
		);
	}
}