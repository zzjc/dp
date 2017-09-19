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
	
	<body>
		<!-------------------------------------- 头部开始 -------------------------------------->
		<header>
			<div class="container">
				
			</div>
		</header>
		<!-------------------------------------- 头部结束 -------------------------------------->
		<!-------------------------------------- 内容开始 -------------------------------------->
		<main>
			<div class="container">
				<div class="ui-userhead">
					<div class="img">
						<img src="<?php echo (session('headimgurl')); ?>" alt="">
						<p><?php echo (session('nickname')); ?> </p>
					</div>
					<div class="txt">
						<div class="coin">
							<p>拥有环保星星<em id="point"><?php echo ($point); ?></em>个</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="ui-tabs">
					<ul>
						<li><a href="<?php echo U('index/lottery');?>" class="i"><i class="ico1"></i>抽奖</a></li>
						<li><a href="javascript:void(0)" class="i on"><i class="ico2"></i>兑奖</a></li>
						<div class="clearfix"></div>
					</ul>
				</div>
				<div class="ht05 bg-gray"></div>
				<div class="ht10"></div>
				<div class="ui-card">
					<ul>
					 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="exchange" data-id='<?php echo ($vo["id"]); ?>' data-rate='<?php echo ($vo["rate"]); ?>'  data-title='<?php echo ($vo["title"]); ?>'>
							<div class="i " style="background-image: url(<?php echo ($vo["pic"]); ?>);  background-size:100% auto;" >
								<p class="p1"><?php echo ($vo["title"]); ?></p>
								<p class="p2">需要<?php echo ($vo["rate"]); ?>颗环保星星</p>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>	
						
						<div class="clearfix"></div>
					</ul>
				</div>
				<div class="ht20"></div>
				<div class="ui-game">
					<div class="text">
						<div class="hd">
							<p><img src="<?php echo C('STATIC_URL');?>Public/home/img/label-l2.png" alt=""></p>
						</div>
						<div class="ct">
							<p>1、每次兑奖会消耗掉规定数量环保星星，耗完即止；</p>
							<p>2、活动时间2017年7月1日至2018年7月1日；</p>
							<p>3、奖品领取方式以主办方的具体通知为准；</p>
							<p>4、本次活动的最终解释权归主办方所有。</p>
							<p>5、最终中奖礼品可能会在颜色和小细节等部分存在差异，具体以实物为准，奖品数量有限兑完即止。</p>
						</div>
					</div>
				</div>
				<div class="ht15"></div>
				<p class="text-center">
					<a href="<?php echo U('index/index');?>" class="bt-1">返回首页</a>
					<span class="wh10"></span>
					<a href="javascript:void(0)" onclick="$('.masker, .ui-box-share').show();" class="bt-1">分享好友</a>
				</p>
				<!--------------------------------------share-------------------------------------->
				<div class="masker"></div>				
				<div class="ui-box-share"><i></i>
					  <div class="ct">
						<p class="p1">
						  点击<img src="<?php echo C('STATIC_URL');?>Public/home/img/pic-share1.png" alt="">或<img src="<?php echo C('STATIC_URL');?>Public/home/img/pic-share2.png" alt="">
						  <br>
						  分享到朋友圈<img src="<?php echo C('STATIC_URL');?>Public/home/img/share.png" style="height: 1.6rem;" alt="">
						</p>
						<p class="p2">即可获得抽奖机会</p>
						<p class="p3">
						  <a onclick="$('.masker, .ui-box-share').hide();" class="ui-btn style2">关闭</a>
						</p>
					  </div>
				</div>
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
		$(".exchange").click(function(){
			var id = $(this).data('id');
			var rate = $(this).data('rate');
			var title = $(this).data('title');
			  layer.open({
				content: '您确定要兑换'+title+'吗？'
				,btn: ['确定', '取消']
				,yes: function(index){
					var url = "<?php echo U('index/ajaxExchange');?>";
					$.post(url, {prize_id:id}, function(data){
							console.log(data);
							if(data.code == 200){ 
								   $('#point').html(data.point);
								   layer.open({
									content: data.msg,
									btn: '去领取',
									yes: function(index){
									   location.href = data.backurl;
									}
								  });	
							}else{
								layerAlert(data.msg);
								return false;
							}
					 },"json");
				}
			  });
			
			
			

		});

	});
</script>