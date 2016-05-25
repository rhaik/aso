<?php

// this contains the application parameters that can be maintained via GUI
return array (
		'description' => '赚大钱',
		'slogan' => '赚大钱',
		'domain' => 'http://test.cn/',
		'imageUrl' => 'http://test.cn/',
		'avatar' => [
			'path' => dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/www/assets/avatar/', 	// 头像保存地址
			'url'  => '',
		],
		'share' => [
			'path' => dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/www/assets/share/',  // 分享图片地址
			'url'  => 'http://test.cn/assets/share/',
		]
);
