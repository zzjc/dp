<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="format-detection" content="telephone=no">
		<title><?php echo ($title); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo C('STATIC_URL');?>Public/home/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?php echo C('STATIC_URL');?>Public/home/css/bootstrap-customize.css">
		<link rel="stylesheet" type="text/css" href="<?php echo C('STATIC_URL');?>Public/home/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo C('STATIC_URL');?>Public/home/css/pages.css?v=4">
		<script type="text/javascript" src="<?php echo C('STATIC_URL');?>Public/home/js/html5.js"></script>
		<script type="text/javascript" src="<?php echo C('STATIC_URL');?>Public/home/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo C('STATIC_URL');?>Public/home/js/bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo C('STATIC_URL');?>Public/home/js/respond.src.js"></script>
		<script type="text/javascript" src="<?php echo C('STATIC_URL');?>Public/home/js/base.js?v=1"></script>
		<script type="text/javascript" src="<?php echo C('STATIC_URL');?>Public/home/js/main.js"></script>
		<script type="text/javascript" src="<?php echo C('STATIC_URL');?>Public/layer/layer.js"></script>
		<!--plugin-->
		<script type="text/javascript" src="<?php echo C('STATIC_URL');?>Public/home/js/jquery.event.move.js"></script>
	</head>
	<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?cf5ae4db6364d9246b6f595c2fae270e";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
	
	<body class="bg-gird">
		<!-------------------------------------- 头部开始 -------------------------------------->
		<header>
			<div class="container">
				
			</div>
		</header>
		<!-------------------------------------- 头部结束 -------------------------------------->
		<!-------------------------------------- 内容开始 -------------------------------------->
		<main>
			<div class="container">
		
				<div class="ht30"></div>
				<div class="ui-event">
					<div class="hd"><label for=""></label>
						<img src="<?php echo C('STATIC_URL');?>Public/home/img/pingshan.png" alt="">
						<p class='p1'>美丽坪山</p>
						<p class='p2'><?php echo ($_GET['month']); ?>月城市管理主题</p>
						<p class='p3'><?php echo ($topic["title"]); ?></p>
					</div>
					<div class="ct">
						<p><?php echo ($topic["content"]); ?></p>
					</div>
				</div>
				<div class="ht40"></div>
				<p class="text-center">
					<a href="javascript:void(0)" class="bt-1" id="start_q">开始答题</a>
				</p>
				<div class="ht20"></div>
			</div>
		</main>
		<!-------------------------------------- 内容结束 -------------------------------------->
		<!-------------------------------------- 尾部开始 -------------------------------------->
		<footer>
			<div class="container">
				
			</div>
		</footer>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=<?php echo C('FRONT_VER');?>"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo ($signPackage["appId"]); ?>',
        timestamp: '<?php echo ($signPackage["timestamp"]); ?>',
        nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
        signature: '<?php echo ($signPackage["signature"]); ?>',
        jsApiList: [
			'showMenuItems',
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			'onMenuShareQQ',
			'onMenuShareWeibo',
			'closeWindow',
			'chooseImage',
			'uploadImage',
			'downloadImage',
			'previewImage',

        ]
    });
	
	wx.ready(function(){
    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
        //分享到朋友圈

		var title = "<?php echo ($setData["title"]); ?>";
		var desc = "<?php echo ($setData["desc"]); ?>";
		var link = "<?php echo ($setData["link"]); ?>";
		var imgUrl = "<?php echo ($setData["imgUrl"]); ?>";

       wx.onMenuShareTimeline({
          title: title, // 分享标题
          link: link, // 分享链接
          imgUrl: imgUrl, // 分享图标
          success: function () { 
               shareBack();
						
          },
          cancel: function () { 
              // 用户取消分享后执行的回调函数
          }
      });

     //分享给朋友
       wx.onMenuShareAppMessage({
          title: title, // 分享标题
          link: link, // 分享链接
          imgUrl: imgUrl, // 分享图标
          desc: desc, // 分享描述
          success: function () { 
              // 用户确认分享后执行的回调函数
			  shareBack();
          },
          cancel: function () { 
              // 用户取消分享后执行的回调函数
          }
      });

       wx.onMenuShareQQ({
          title: title, // 分享标题
          link: link, // 分享链接
          imgUrl: imgUrl, // 分享图标
          desc: desc, // 分享描述
          success: function () { 
             // 用户确认分享后执行的回调函数
          },
          cancel: function () { 
             // 用户取消分享后执行的回调函数
          }
      });


    });
    
	
	function shareBack(){
		var url = "<?php echo U('index/ajaxShare');?>";
		$.post(url, {id:''}, function(data){
			console.log(data);
		 },"json");
		//var url = "<?php echo U('Index/detail');?>";
		//location.href = url;
	}
</script>	
	
		<!-------------------------------------- 尾部开始 -------------------------------------->
	</body>
</html>
<style>
	
</style>
<script>
	$(function(){
	
		$("#start_q").click(function(){
			var month = <?php echo ($_GET['month']); ?>;
			var url = "<?php echo U('index/ajaxquestion');?>";
			$.post(url, {month:month}, function(data){
					console.log(data);
					if(data.code == 200){     
						location.href = data.backurl;
					}else{
						layerAlert(data.msg);
						return false;
					}
			 },"json");

		});
		 
	});
</script>