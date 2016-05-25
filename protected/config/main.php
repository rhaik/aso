<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'		=> dirname(__FILE__).DIRECTORY_SEPARATOR.'../',
	'name'			=> '赚大钱',

	// preloading 'log' component
	'preload' 	=> array('log'),
	'charset'	=> 'UTF-8', 	//设置网站字符编码  
	'timeZone' 	=> 'PRC',
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.models.user.*',
		'application.models.app.*',
		'application.business.cache.*',
		'application.business.user.*',
		'ext.token.*',
		'ext.request.*',
		'ext.restfull.*',
		'ext.YiiRedis.*',
		'ext.amqp.*',
	),
	'defaultController' => 'index',
	// application components
	'components'=> array_merge(
		require(dirname(__FILE__).'/dbconfig.php'),
		array( 
			//token组件
			'token' => array (
				'class' => 'ext.token.TokenComponent',
				'secretKey' => '123456',
				'expire'	=> 3600 * 12
			),
			//请求参数验证组件
			'requestFilter' => array (
				'class' => 'ext.request.RequestFilterComponent',
				'duration' => '600',
				'encryptionKey'=> 'lieqicun',
				'disabled' => true,
			),
			//redis组件
			"redis" => array(
					"class" => "ext.YiiRedis.ARedisConnection",
					"hostname" => "114.215.130.131",
					"port" => 6379,
					"database" => 1,
					"prefix" => "Yii.redis."
			),
			//消息队列
			'amqp' => [
						'class' => 'ext.amqp.CAMQP',
						'server' => [ 
								'host' => '127.0.0.1',
								'port' => '5672',
								'vhost' => '/',
								'login' => 'rabbit2015',
								'password' => 'mapi_lieqicun_cn' 
						],
						'durable' => true,
						'autodelete' => true 
			],
			//memcahe缓存
			'cache'=>array( 
				'class'			=>'CMemCache', 
				'servers'		=> array(
					array ('host' => '127.0.0.1', 'port' => '12000', 'weight' => 100, 'timeout'=> 1, 'retryInterval'=> 600)
				),
				'keyPrefix' 	=> '', 
				'hashKey' 		=> false, 
				'serializer'	=> false 
			), 
			//url管理
			'urlManager' => array (
				'class' => 'UrlManager',
				'urlFormat' => 'path',
				'showScriptName' => false,
				'resources' => array (
						'User','Task','UserIdea','InvitationUser', 'Message','UserAction','Enchashment'
				) 
			),
			//处理没有捕获的 PHP 错误和例外
			'errorHandler'=>array(
				// use 'site/error' action to display errors
				'errorAction'=>'site/error',
			),
			//日志
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning',
						'logFile' => 'log_'. date('Y-m-d'). '.log',
						'maxFileSize' => 10240,
						'maxLogFiles'=> 1000,
					),
					array(
						'class' 		=> 'CFileLogRoute',
						'levels'		=> 'error,warning',
						'logPath'		=> dirname( dirname(__FILE__) ) . '/runtime/sql/',
						'logFile' 		=> 'sql_'. date('Y-m-d'). '.log',
						'maxFileSize' 	=> 10240,
						'maxLogFiles'	=> 1000,
						'categories'	=> 'system.db.CDbCommand'
					),
					array(
						'class' 		=> 'CFileLogRoute',
						'levels'		=> 'error,warning,info',
						'logFile' 		=> 'userAction_'. date('Y-m-d'). '.log',
						'maxFileSize' 	=> 10240,
						'maxLogFiles'	=> 1000,
						'categories'	=> 'UserAction.*'
					),
				),
			)
		)
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);