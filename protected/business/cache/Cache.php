<?php
/**
 * 
 * 缓存抽像类
 * 
 * 1:继承者必须定义自己的缓存KEY变量:key
 * 2:继承者必须定义自己的缓存数据方法:loadCacheData()
 * 
 *
 * @author zhanghaisong 2014-2-14
 *
 */
class Cache {
	/**
	 *
	 *
	 * 缓存对像
	 *
	 * @var Object
	 */
	protected $cache = null;
	/**
	 *
	 *
	 * 缓存类型
	 *
	 * @var string
	 */
	protected $type = 'Memcache';
	/**
	 *
	 *
	 * 缓存KEY
	 *
	 * @var string
	 */
	protected $cacheKey = '';
	/**
	 *
	 *
	 * 缓存数据
	 *
	 * @var array
	 */
	protected $cacheData = array ();
	/**
	 *
	 *
	 * 缓存时间
	 *
	 * @var integer
	 */
	protected $expire = 0;
	/**
	 *
	 *
	 * 构造方法
	 *
	 * @param string $type        	
	 *
	 */
	public function __construct($type = 'Memcache') {
		$this->type = $type;
		$this->cache = Yii::app ()->getCache ();
		
		/*
		 * if (empty ( $this->cache )) { $this->cache = Yii::app ()->filecache; }
		 */
	}
	/**
	 *
	 *
	 *
	 * 缓存是否存在
	 *
	 * @return boolean
	 */
	public function isExist($params = 0) {
		return $this->cache->offsetExists ( $this->getCacheKey ( $params ) );
	}
	
	/**
	 *
	 *
	 * 更新缓存
	 *
	 * @return boolean
	 */
	public function updateCache($params = 0) {
		return $this->cache->set ( $this->getCacheKey ( $params ), $this->loadCacheData ( $params ), $this->getExpire () );
	}
	/**
	 *
	 *
	 * 获取缓存
	 *
	 * @return array
	 */
	public function getCache($params = 0) {
		return $this->cache->get ( $this->getCacheKey ( $params ) );
	}
	/**
	 *
	 *
	 * 清除缓存
	 *
	 * @return array
	 */
	public function deleteCache($params = 0) {
		return $this->cache->delete ( $this->getCacheKey ( $params ) );
	}
	/**
	 *
	 *
	 * 设置缓存KEY
	 *
	 * @param string $key        	
	 */
	public function setCacheKey($key) {
		$this->cacheKey = $key;
	}
	/**
	 *
	 *
	 * 获取缓存KEY
	 *
	 *
	 * @return string
	 */
	public function getCacheKey($params = 0) {
		return $params ? $this->cacheKey . $params : $this->cacheKey;
	}
	/**
	 *
	 *
	 * 设置过期时间
	 *
	 * @param integer $expire        	
	 *
	 */
	public function setExpire($expire) {
		$this->expire = $expire;
	}
	/**
	 *
	 *
	 * 获取过期时间
	 *
	 *
	 * @return string
	 */
	public function getExpire() {
		return $this->expire;
	}
}