<!DOCTYPE html>
<html>  
    <head>
        <meta charset="utf-8" />
        <meta name="author" content="rhaik" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title><?php echo $this->title;?>-猎奇赚钱</title> 
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['domain'];?>assets/frozenui/1.2.1/css/frozen.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['domain'];?>assets/demo.css"> 
        <script src="<?php echo Yii::app()->params['domain'];?>assets/frozenjs/lib/zepto.min.js"></script>
        <script src="<?php echo Yii::app()->params['domain'];?>assets/frozenjs/1.0.1/frozen.js"></script> 
    </head>
<body>
	<?php echo $content; ?>
</body>
</html>