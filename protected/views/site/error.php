<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - 提示';

?>

<h2>错误 <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>