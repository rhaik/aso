<ul class="ui-list ui-list-active ui-border-tb">
	<?php if(!empty($data)):foreach ($data as $v):?>
    <li class="ui-border-t" style="height:80px;">
		<div class="ui-list-info">
			<h4>账号：<?php echo $v['account'];?></h4>
			<p style="margin-top:4px;font-size:16px;"><?php echo $v['createTime'];?><span style="margin-left: 10px;color:#e60012;">￥<?php echo $v['amount'];?></span>
			</p>
		</div>
		<div style="position: absolute; right:20px; margin:30px 10px;font-size:16px;">
			<?php $statusArray = [1=>'待审核',2=>'已审核',3=>'审核未通过',4=>'打款成功',5=>'打款失败']; echo '<span style="color:'.($v['status'] ==5 ? '#666666' : '#e60012').'">'.$statusArray[$v['status']] . '</span>';?>
		</div>
	</li>
    <?php endforeach;endif;?>
</ul>