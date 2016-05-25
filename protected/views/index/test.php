<ul class="ui-list ui-list-link ui-border-tb">
	<li class="ui-border-t" data-url="/?token=<?php echo $token;?>">
        <div class="ui-list-thumb">
            <span  style="background-image:url(<?php echo Yii::app()->params['domain']; ?>assets/images/found_01.png)"></span>
        </div>
        <div class="ui-list-info">
            <h4>首页</h4>
        </div>
    </li>
    <li class="ui-border-t" data-url="/Task/?token=<?php echo $token;?>">
        <div class="ui-list-thumb">
            <span  style="background-image:url(<?php echo Yii::app()->params['domain']; ?>assets/images/found_01.png)"></span>
        </div>
        <div class="ui-list-info">
            <h4>应用试用</h4>
        </div>
    </li>
    <li class="ui-border-t" data-url="/Rank/?token=<?php echo $token;?>">
        <div class="ui-list-thumb">
           <span style="background-image:url(<?php echo Yii::app()->params['domain']; ?>assets/images/found_02.png)"></span>
        </div>
        <div class="ui-list-info">
            <h4>收入排行榜</h4>
        </div>
    </li>
    <li class="ui-border-t" data-url="/Task/My/?token=<?php echo $token;?>">
        <div class="ui-list-thumb">
           <span style="background-image:url(<?php echo Yii::app()->params['domain']; ?>assets/images/found_03.png)"></span>
        </div>
        <div class="ui-list-info">
            <h4>我的任务</h4>
        </div>
    </li>
    <li class="ui-border-t" data-url="/InvitationUser/?token=<?php echo $token;?>">
        <div class="ui-list-thumb">
           <span style="background-image:url(<?php echo Yii::app()->params['domain']; ?>assets/images/found_03.png)"></span>
        </div>
        <div class="ui-list-info">
            <h4>邀请记录列表</h4>
        </div>
    </li>
    <li class="ui-border-t" data-url="/Enchashment/Page?token=<?php echo $token;?>">
        <div class="ui-list-thumb">
           <span style="background-image:url(<?php echo Yii::app()->params['domain']; ?>assets/images/found_03.png)"></span>
        </div>
        <div class="ui-list-info">
            <h4>提现</h4>
        </div>
    </li>
    <li class="ui-border-t" data-url="/Enchashment/?token=<?php echo $token;?>">
        <div class="ui-list-thumb">
           <span style="background-image:url(<?php echo Yii::app()->params['domain']; ?>assets/images/found_03.png)"></span>
        </div>
        <div class="ui-list-info">
            <h4>提现列表</h4>
        </div>
    </li>
</ul>
<script>
$(function(){
	$('.ui-border-t').click(function(){
		window.location.href= $(this).attr('data-url');
	});
});
</script>