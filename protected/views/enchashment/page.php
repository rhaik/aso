<style>
.ui-form-item {
	margin: 10px 10px;
	height:auto;
}
.errorMessage{margin-bottom:10px;height:30px;};
</style>
<?php echo CHtml::beginForm("/Enchashment",'POST',array('id'=>'EnchashmentForm')); ?>

<div class="ui-form ui-border-t">
		<input type="hidden" name="token" value="<?php echo $token;?>" />
		<div style="height: 80px; margin: 0 auto; text-align: center;">
			<img alt="支付宝" src="/assets/images/enchashment_01.jpg" style="height: 80px;">
		</div>
		<div class="ui-form-item ui-border-tb">
			<label for="#">账号：</label> <input type="text" name="data[account]"  placeholder="输入您的支付宝账号" id="User_Name">
			<a href="#" class="ui-icon-close"></a>
			<?php echo CHtml::error($form, 'account');?>
		</div>
		<div class="ui-form-item ui-border-b">
			<label for="#">姓名：</label> <input type="text" name="data[account_name]"  placeholder="输入您的真实姓名" id="User_Pwd">
			<a href="#" class="ui-icon-close"></a>
			<?php echo CHtml::error($form, 'account_name');?>
		</div>
		<div class="ui-form-item ui-border-b">
			<label for="#">金额：</label> <input type="text" name="data[amount]" placeholder="输入您的提现金额" id="User_Pwd1">
			<a href="#" class="ui-icon-close"></a>
			<?php echo CHtml::error($form, 'amount');?>
		</div>
</div>

<ul class="ui-list ui-list-text ui-list-checkbox" style="height: 50px;">
	<li class="ui-border-t"><label class="ui-checkbox"> <input
			type="checkbox" name="data[default]" id="">
	</label>
		<p>设置为默认账号</p>
		<div style="position: absolute; right: 20px; color: #4788ff"><a href="/Enchashment/?token=<?php echo $token;?>">查看提现记录</a></div>
	</li>
</ul>
<div style="margin: 40px 20px;">
	<button class="ui-btn-lg" type="submit"
		style="height: 50px; color: #ffffff; background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.5, #ff8003), to(#ff8003)); background-color: #ff8003;">立即提取</button>
</div>
<div style="color: #e60012;font-size:16px; line-height: 26px; padding:0px 20px;">
	<p>注意：仔细核对您的支付宝账号和姓名，以免提现无法准确到账</p>
</div>
<?php echo CHtml::endForm();?>
<script>
$('.ui-icon-close').click(function(){
	$(this).parent().find('input').val('');
});
</script>