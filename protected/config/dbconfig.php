<?php
define('MAIN_IP', '127.0.0.1');			//主库IP
define('SLAVES_IP', '192.168.1.130');		//从库IP
/**
 * 数据库配置
 */
return array(
	//money库
	'money'=>array(
        'class'=>'application.extensions.DbConnection',				//扩展路径
        'connectionString' 	=> 'mysql:host=' . MAIN_IP . ';dbname=money',//主数据库 写
        'emulatePrepare'	=> true,
		'enableParamLogging'=> true,
        'username' 			=> 'money',
        'password' 			=> 'eQUh4UXGwT8YuBDW',
        'charset' 			=> 'utf8',
        'tablePrefix' 		=> 'money_', //表前缀
        'enableSlave'		=> false,	//从数据库启用
		'slavesWrite'		=> false,	//紧急情况 主数据库无法连接 启用从数据库 写功能
		'masterRead'		=> true,	//紧急情况 从数据库无法连接 启用主数据库 读功能
        'slaves'			=> array(	//从数据库
            array(   //slave1
                'connectionString'	=> 'mysql:host=' . SLAVES_IP . ';dbname=money',
                'emulatePrepare' 	=> true,
                'username'			=> 'root',
                'password'			=> '',
                'charset' 			=> 'utf8',
                'tablePrefix' 		=> 'money_', //表前缀
            )
        ),
    )
);