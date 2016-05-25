<style>
.ui-tab-nav li{font-size:18px;}
.ui-avatar-thumb{margin-right: 20px;}
.ui-list-thumb{margin:5px 10px 0px 0px;}
.ui-list-info{font-size:20px;}
.ui-list-action{font-size: 20px;}
</style>
<div class="ui-tab">
    <ul class="ui-tab-nav ui-border-b">
        <li  class="current">本月排行</li>
        <li>总排行</li>
    </ul>
    <div style="height: 16px;"></div>
    <ul class="ui-tab-content">
        <li>
        	<ul class="ui-list ui-border-tb">
				<?php if(!empty($monthData)):foreach ($monthData as $k=>$v):?>
			    <li class="ui-border-t">
			    	<div class="ui-avatar-thumb">
			           <?php if($k < 3):?><img src="<?php echo Yii::app()->params['domain']; ?>assets/images/rank_0<?php echo $k+1;?>.png" style="width:53px;height:50px;" />
			           <?php else: echo $k+1; endif;?>
			        </div>
			        <div class="ui-list-thumb">
			            <span style="background-image:url(<?php echo $v['userAvatar']?>);width:44px;height:44px;border-radius:10px;"></span>
			        </div>
			        <div class="ui-list-info">
			            <h1><?php echo $v['userName'];?></h1>
			        </div>
			        <div class="ui-list-action ui-txt-warning">￥<?php echo $v['total']?></div>
			    </li>
			    <?php endforeach;endif;?>
			</ul>
        </li>
        <li>
        	<ul class="ui-list ui-border-tb">
				<?php if(!empty($totalData)):foreach ($totalData as $k=>$v):?>
			    <li class="ui-border-t">
			    	<div class="ui-avatar-thumb">
			           <?php if($k < 3):?><img src="<?php echo Yii::app()->params['domain']; ?>assets/images/rank_0<?php echo $k+1;?>.png" style="width:53px;height:50px;" />
			           <?php else: echo $k+1; endif;?>
			        </div>
			        <div class="ui-list-thumb">
			            <span style="background-image:url(<?php echo $v['userAvatar']?>);width:44px;height:44px;border-radius:10px;"></span>
			        </div>
			        <div class="ui-list-info">
			            <h1><?php echo $v['userName'];?></h1>
			        </div>
			        <div class="ui-list-action ui-txt-warning">￥<?php echo $v['total']?></div>
			    </li>
			    <?php endforeach;endif;?>
			</ul>
        </li>
    </ul>
</div>
<div class="ui-btn-group ui-btn-group-bottom" style="display:block;">
	<ul id="sharePage" class="ui-list ui-list-function ui-border-t" data-url="/Rank/Share/?token=<?php echo $token;?>">
	    <li class="ui-border-t ui-list-item-link">
	        <div class="ui-list-thumb" style="margin:8px 25px 10px 0px;">
	            <img src="<?php echo $user['avatar']?>" style="width:54px;height:54px;border-radius:10px;" />
	        </div>
	        <div class="ui-list-info">
	            <h4 style="font-size:22px;color:#000000;margin-top:10px;"><?php echo $v['userName'];?></h4>
	            <div style="margin-top:4px;font-size:18px;color:#666666">财富：<span style="color:#e60012">￥<?php echo $user['amount']?></span></div>
	        </div>
	    </li>
	    <li class="ui-border-t">
	        <div class="ui-badge-wrap" style="font-size:18px;color:#666666;width: 50%;line-height: 40px;">我的本月排名</div>
	        <div class="ui-badge-wrap" style="font-size:18px;color:#666666;width: 50%;line-height: 40px;">我的总排名</div>
	    </li>
		<li>
	        <div class="ui-badge-wrap" style="font-size:25px;color:#000000;width: 50%;line-height: 25px;"><?php echo $user['rankMonth']?></div>
	        <div class="ui-badge-wrap" style="font-size:25px;color:#000000;width: 50%;line-height: 25px;"><?php echo $user['rankTotal']?></div>
	    </li>
	</ul>
</div>
<script>
$(function(){
    var tab = new fz.Scroll('.ui-tab', {
        role: 'tab',
        autoplay: false,
    });

    tab.on('beforeScrollStart', function(fromIndex, toIndex) {
        console.log(fromIndex, toIndex)
    });

    tab.on('scrollEnd', function() {
        console.log('end')
    });
    $('#sharePage').click(function(){
    	window.location.href= $(this).attr('data-url');
    });
});
</script>