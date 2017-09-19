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
							<p>拥有环保星星<em><?php echo ($point); ?></em>个</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="ui-txt1">
					<div class="hd">
						<p class="p1">关爱坪山，你我共同守护！</p>
						<div class="ht10"></div>
						<p class="p2"><img src="<?php echo C('STATIC_URL');?>Public/home/img/label-l3.png" alt=""></p>
					</div>
					<div class="ct">
						<p>关于城市管理，你知多少？参与“人人都是城市美容师”互动闯关答题游戏，为创建美丽坪山街道添砖加瓦。完成答题赢取城市守卫者勋章，答对一题获得一枚勋章，使用勋章可以参与抽奖和兑奖活动。奖品丰厚，中奖率高哦！</p>
					</div>
				</div>
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
				<div class="ht10"></div>
				<p class="text-center">
					<a href="<?php echo U("index/start",array('month'=>$month));?>" class="bt-1">答题赢礼品</a>
				</p>
			</div>
		</main>
		<!-------------------------------------- 内容结束 -------------------------------------->
		<!-------------------------------------- 尾部开始 -------------------------------------->
		<footer>
			<div class="container">
				
			</div>
		</footer>
		<!-------------------------------------- 尾部开始 -------------------------------------->
	</body>
</html>
<style>
	
</style>
<script>
	$(function(){
		$(".exchange").click(function(){
			var url = "<?php echo U("index/exchange");?>";
			location.href = url;
		});

	});
</script>