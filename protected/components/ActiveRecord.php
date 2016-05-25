<?php
/**
 * 
 * 基于CActiveRecord类的封装，实现多库和主从读写分离
 * 所有Model都必须继承些类.
 *
 * @author zhanghaisong 2014-1-7
 *
 */
class ActiveRecord extends CActiveRecord {
	/**
	 * 
	 * 数据库名
	 *
	 * @var string
	 */
	private $dbName = '';
	/*
	 * 定义一个多数据库集合
	 */
	static $dataBase = array ();
	/**
	 * 在原有基础上添加了一个dbname参数
	 * 
	 * @param string $scenario Model的应用场景
	 * @param string $dbname 数据库名称
	 */
	public function __construct($scenario = 'insert', $dbname = '') {
		if (! empty ( $dbname ))
			$this->dbName = $dbname;
		
		parent::__construct ( $scenario );
	}
	/**
	 * 
	 * 设置DB库
	 *
	 * @param string $dbname
	 *
	 */
	public function setDbName($dbname) {
		$this->dbName = $dbname;
	}
	/**
	 * 
	 * 获取db库
	 *
	 *
	 * @return  string
	 */
	public function getDbName() {
		return $this->dbName;
	}
	/**
	 * 
	 * 重写父类的getDbConnection方法
	 */
	public function getDbConnection() {
		$tableName = $this->tableName ();
		$dbName = substr ( $tableName, 0, stripos ( $tableName, '_' ) );
		$this->setDbName ( $dbName );
		
		//如果指定的数据库对象存在则直接返回
		if (self::$dataBase [$this->getDbName ()] !== null)
			return self::$dataBase [$this->getDbName ()];
		
		if (Yii::app ()->getComponent ( $this->getDbName () ) !== null) {
			self::$dataBase [$this->getDbName ()] = Yii::app ()->getComponent ( $this->getDbName () );
		}
		
		if (self::$dataBase [$this->getDbName ()] instanceof CDbConnection) {
			self::$dataBase [$this->getDbName ()]->setActive ( true );
			return self::$dataBase [$this->getDbName ()];
		} else {
			throw new CDbException ( Yii::t ( 'yii', 'Model requires a "db" CDbConnection application component.' ) );
		}
	}
}