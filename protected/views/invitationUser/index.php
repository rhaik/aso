<ul class="ui-list ui-border-tb">
	<?php if(!empty($data)):foreach ($data as $v):?>
    <li class="ui-border-t">
    	<div class="ui-avatar-s">
           <span style="background-image:url(<?php echo $v['friendAvatar'];?>)"></span>
        </div>
        <div class="ui-list-info">
            <h4><?php echo $v['friendName'];?></h4>
        </div>
        <div style="position: absolute;height:30px;top:60%;right:15px;margin-top:-15px;"><?php echo $v['createTime'];?></div>
    </li>
    <?php endforeach;endif;?>
</ul>