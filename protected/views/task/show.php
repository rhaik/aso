<style>
.ui-list li{margin-left:0px;}
</style>
<ul class="ui-list ui-list-function ui-border-b">
    <li class="ui-border-tb">
        <div class="ui-list-thumb" style="margin-left:15px;width:60px;height:60px;">
            <span style="background-image:url(<?php echo $data['appIcon'];?>);border-radius:15px;"></span>
        </div>
        <div class="ui-list-info" style="margin-left:10px;">
            <h4 style="font-size:22px; width:90px; white-space:nowrap;overflow:hidden;text-overflow:clip;"><?php echo $data['name'];?></h4>
        </div>
        <a href="<?php echo $data['appUrl'];?>"><button class="ui-btn" style="border:0;color:#ffffff;font-size:16px;height:34px;background:url(/assets/images/task_02.png) center no-repeat;">试玩奖励<?php echo $data['amount']?>元</button></a>
    </li>
    <li style="background-color: #e0e0e0;height:15px;">
    </li>
    <li class="ui-border-t">
    	<div style="margin:15px 15px; line-height:24px; color:#5F5C5C"><?php echo $data['description'];?></div>
    </li>
</ul>
<div class="ui-btn-group ui-btn-group-bottom" style="background:url(/assets/images/task_03.png) center repeat-x;background-size:100% 100%;padding-bottom:5px;">
    	 <div style="color: #ffffff;line-height:26px;padding-left:20px;"><p>试完提示：</p>
    	 <p>1、请尽快下载试完5分钟，否则应用将会过期</p>
    	 <p>2、iPad用户请在跳转后选择仅iPhone下载</p>
    	 <p>3、试客=唯一微信+唯一设备号+唯一苹果账号，</p>
    	 <p style="padding-left:20px;">不能相互混乱，否则无法获得奖励</p>
    	 </div>
</div>