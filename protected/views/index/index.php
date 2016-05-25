<style>
.ui-tab-nav{padding-top:10px;height:60px;}
.ui-tab-nav li{font-size:18px;}
.ui-tab-nav li.current {height:50px; color: #e90010;border-bottom:0;}
.ui-badge-wrap{width: 50%;line-height: 30px;}
.font_size{font-size:20px;}
</style>
<div class="ui-tab">
	<ul class="ui-tab-nav ui-border-b ui-border-t">
	    <li class="current" >昨日累积</li>
	    <li>最近七天</li>
	    <li>最近30天</li>
	</ul>
	<ul class="ui-tab-content" style="margin-top:60px;width: 300%;">
		<li> 
			<ul class="ui-list ui-list-text">
			   <li class="ui-border-t" style="padding: 20px 25px 5px 0px;">
			        <div class="ui-badge-wrap">应用试用</div>
			        <div class="ui-badge-wrap">邀请分成</div>
			    </li>
				<li style="padding: 5px 25px 25px 0px;">
			        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['yesterdayAppAmount']; ?></span></div>
			        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['yesterdayFriendsAmount']; ?></span></div>
			    </li>
			</ul>
		</li>
		<li> 
			<ul class="ui-list ui-list-text">
			   <li class="ui-border-t" style="padding: 20px 25px 5px 0px;">
			        <div class="ui-badge-wrap">应用试用</div>
			        <div class="ui-badge-wrap">邀请分成</div>
			    </li>
				<li style="padding: 5px 25px 25px 0px;">
			        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['7dayAppAmount']; ?></span></div>
			        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['7dayFriendsAmount']; ?></span></div>
			    </li>
			</ul>
		</li>
		<li> 
			<ul class="ui-list ui-list-text">
			   <li class="ui-border-t"  style="padding: 20px 25px 5px 0px;">
			        <div class="ui-badge-wrap">应用试用</div>
			        <div class="ui-badge-wrap">邀请分成</div>
			    </li>
				<li style="padding: 5px 25px 25px 0px;">
			        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['30dayAppAmount']; ?></span></div>
			        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['30dayFriendsAmount']; ?></span></div>
			    </li>
			</ul>
		</li>
	</ul>
</div>
<ul class="ui-list ui-list-text ui-border-t ui-border-b" style="margin-top:30px;" >
    <li class="ui-center" style="width:auto;height:50px;">
    	<div class="ui-border-b ui-center" style="width:96%;height:100%;line-height:100%;font-size:20px;">账户概览</div>
    </li>
     <li style="padding: 4px 25px 5px 0px;">
        <div class="ui-badge-wrap">本月收入</div>
        <div class="ui-badge-wrap">上月收入</div>
    </li>
	<li style="padding: 5px 25px 5px 0px;">
        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['currentMonth']; ?></span></div>
        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['lastMonth']; ?></span></div>
    </li>
	<li style="padding: 10px 25px 5px 0px;">
        <div class="ui-badge-wrap">账户余额</div> 
    </li>
	<li style="padding: 5px 25px 25px 0px;">
        <div class="ui-badge-wrap">￥<span class="font_size"><?php echo $data['amount']; ?></span></div> 
    </li>
</ul>
<script>
    window.addEventListener('load', function(){
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
   })    
</script>
