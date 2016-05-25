<script src="http://mapi.lieqicun.cn/assets/jquery-1.10.2.min.js"></script>
<script>
//用户注册接口
$.ajax({
   type: "POST",  //必须post
   dataType:'json',
   data:{'data':{'avatar':'头像','name':'名称','openid':'微信openid','area':'地区','appleid':'设备号'}},   
   url: "http://mapi.lieqicun.cn/User/", 
   success: function(data){
   		alert(data);
   }
});

//用户刷新TOKEN
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'openid':'微信openid'},   
	   url: "http://mapi.lieqicun.cn/User/RefreshToken", 
	   success: function(data){
	   		alert(data);
	   }
});
//用户统计信息
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN'},   
	   url: "http://mapi.lieqicun.cn/", 
	   success: function(data){
	   		alert(data);
	   }
});

//用户消息
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN'},   
	   url: "http://mapi.lieqicun.cn/Message/", 
	   success: function(data){
	   		alert(data);
	   }
});

//用户应用消息列表
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN','pageon':'当前页'},   
	   url: "http://mapi.lieqicun.cn/Message/App", 
	   success: function(data){
	   		alert(data);
	   }
});
//用户好友消息列表
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN','pageon':'当前页'},   
	   url: "http://mapi.lieqicun.cn/Message/Friend", 
	   success: function(data){
	   		alert(data);
	   }
});
//用户系统消息列表
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN','pageon':'当前页'},   
	   url: "http://mapi.lieqicun.cn/Message/System", 
	   success: function(data){
	   		alert(data);
	   }
});

//标识消息已读
$.ajax({
	   type: "PUT", 
	   dataType:'json',
	   data:{'token':'用户TOKEN','type':'类型(system|app|friend)'},   
	   url: "http://mapi.lieqicun.cn/Message/{消息ID}", 
	   success: function(data){
	   		alert(data);
	   }
});
//用户总排行
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN'},   
	   url: "http://mapi.lieqicun.cn/Rank/", 
	   success: function(data){
	   		alert(data);
	   }
});
//用户月排行
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN'},   
	   url: "http://mapi.lieqicun.cn/Rank/Month", 
	   success: function(data){
	   		alert(data);
	   }
});

//用户任务列表
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN'},   
	   url: "http://mapi.lieqicun.cn/Task/", 
	   success: function(data){
	   		alert(data);
	   }
});
//用户查看任务
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN'},   
	   url: "http://mapi.lieqicun.cn/Task/{任务ID}", 
	   success: function(data){
	   		alert(data);
	   }
});
//用户操作日志
$.ajax({
	   type: "POST", 
	   dataType:'json',
	   data:{'token':'用户TOKEN','data':{'user_id':'用户ID','app_id':'应用ID','app_task_id':'任务ID','action':'动作类型(1:搜索2:下载,3:浏览)',	'action_time':'动作时间','appleid':'设备号' }},   
	   url: "http://mapi.lieqicun.cn/UserAction/", 
	   success: function(data){
	   		alert(data);
	   }
});

//用户邀请好友列表
$.ajax({
	   type: "GET", 
	   dataType:'json',
	   data:{'token':'用户TOKEN'},   
	   url: "http://mapi.lieqicun.cn/InvitationUser/", 
	   success: function(data){
	   		alert(data);
	   }
});

//用户邀请好友
$.ajax({
	   type: "POST", 
	   dataType:'json',
	   data:{'token':'用户TOKEN','data':{'friends':'邀请好友ID'}},   
	   url: "http://mapi.lieqicun.cn/InvitationUser/", 
	   success: function(data){
	   		alert(data);
	   }
});
//用户见反溃
$.ajax({
	   type: "POST", 
	   dataType:'json',
	   data:{'token':'用户TOKEN','data':{'content':'内容','version':'版本号','equipment':'设备'}},   
	   url: "http://mapi.lieqicun.cn/UserIdea/", 
	   success: function(data){
	   		alert(data);
	   }
});

</script>