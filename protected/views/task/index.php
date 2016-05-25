<ul class="ui-list ui-list-active ui-border-tb">
	<?php if(!empty($data)):foreach ($data as $v):?>
    <li class="ui-border-t" data-id="<?php echo $v['id'];?>">
        <div class="ui-list-thumb">
            <span style="background-image:url(<?php echo $v['appIcon'];?>);border-radius:10px;"></span>
        </div>
        <div class="ui-list-info">
            <h4><?php echo $v['appName'];?></h4>
            <p><?php echo $v['name'];?></p>
        </div>
        <button class="ui-btn" style="border:0;color:#ffffff;font-size:18px;height:34px;width:70px;background:url(/assets/images/task_01.png) center no-repeat">￥<?php echo $v['amount'];?></button>
    </li>
    <?php endforeach;endif;?>
</ul>

<script>
$(function(){
	$('.ui-border-t').click(function(){
		window.location.href='/Task/' + $(this).attr('data-id') + '?token=<?php echo $token;?>';
	});
});
</script>