<?php
/**
 * 
 * 缓存管理类
 *
 * @author zhanghaisong 2014-2-14
 *
 */
class CacheM {
	/**
	 * 
	 * 缓存对像
	 *
	 * @var Cache
	 */
	public static $classObj = array();
	/**
	 * 
	 * 创建缓存对像
	 *
	 * @param string $type
	 *
	 * @return  Cache
	 */
	public static function create($type) {
		if (! isset ( self::$classObj [$type] )) {
			$class = $type . 'Cache';
			if (class_exists ( $class )) {
				self::$classObj [$type] = new $class ();
			}
		}
		return self::$classObj [$type];
	}
	/**
	 * 
	 * 获取缓存数据
	 *
	 * @param string $type	类型
	 * @param	integer|array|string	$params 	参数
	 *
	 * @return  array
	 */
	public static function get($type, $params = 0) {
		$cache = self::create ( $type );
		$cacheData = $cache->getCache ( $params );
		if ($cacheData === false) {
			$cache->updateCache ( $params );
			$cacheData = $cache->loadCacheData ( $params );
		}
		return $cacheData;
	}
	/**
	 * 
	 * 设置缓存
	 *
	 * @param 	string 	$type	类型
	 * @param	integer|array|string	$params 	参数
	 *
	 * @return  boolean
	 */
	public static function set($type, $params = 0) {
		$cache = self::create ( $type );
		return $cache->updateCache ($params);
	}
	/**
	 * 
	 * 删除缓存
	 * @param string $type 类型
	 * @param interger $params 参数
	 */
	public static function del($type,$params = 0) {
		$cache = self::create ( $type );
		return $cache->deleteCache ( $params );	
		
	}
	
	/**
	 * 
	 * 判断缓存是否存在
	 * @param string $type 类型
	 * @param interger $params 参数
	 */
	public static function exist($type,$params = 0) {
		$cache = self::create ( $type );
		return $cache->isExist($params);
	}	
}