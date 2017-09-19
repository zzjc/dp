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
				<div class="ui-head">
					<p>
						<img src="<?php echo C('STATIC_URL');?>Public/home/img/logo.png" alt="" class="logo">
					</p>
				</div>
				<div class="ht35"></div>
				
				<div class="ui-result">
					<div class="hd">
						<p><?php echo ($answerInfo["msg"]); ?></p>
					</div>
					<div class="ct">
						<p>
							<?php if($answerInfo["is_right"] == 2): ?><b>你的答案：</b><?php echo ($answerArr[$answerInfo['answer']]); ?><br><?php endif; ?>
							<b><em>正确答案：</em></b><em><?php echo ($answerArr[$answerInfo['right_answer']]); ?></em><br>
							<b>答案解析：</b>【你知道吗】<?php echo ($answerInfo["knowledge"]); ?><br>
						</p>
					</div>
				</div>
				<?php if(!empty($rightCount)): ?><div class="ui-gain">
					<div class="hd">
						<p>恭喜你已完成了所有答题，堪称答题小能手！</p>
					</div>
					<div class="ct">
						<p>
							本轮答题你一共答对 <b class="color1"><?php echo ($rightCount); ?></b> 题，答错 <b class="color2"><?php echo 10-$rightCount;?></b> 题<br>
							本次获得环保星星 <img src="<?php echo C('STATIC_URL');?>Public/home/img/coin-l1.png" alt=""> <?php echo ($rightCount); ?> 颗，累计收获<?php echo ($point); ?>颗环保星星。
						</p>
					</div>
					<div class="ft">
						<h3><img src="<?php echo C('STATIC_URL');?>Public/home/img/icon-faq.png" alt="">环保星星怎么用？</h3>
						<p>消耗3个环保星星可抽奖1次，攒足20个环保星星可兑换奖品。</p>
					</div>
				</div>
				<div class="ht20"></div>
				<p class="text-center">
					<a href="<?php echo U('index/lottery');?>" class="bt-1">我要抽奖</a>
					<span class="wh15"></span>
					<a href="<?php echo U('index/exchange');?>" class="bt-1">兑换礼品</a>
				</p>
				<div class="ht20"></div>
				<?php else: ?>
					<div class="ht20"></div>
					<p class="text-center">
					<a href="javascript:void(0)" class="bt-1" id="start_q">下一题</a>
				</p>
				<div class="ht20"></div><?php endif; ?>
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
			var month = <?php echo ($answerInfo["month"]); ?>;
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