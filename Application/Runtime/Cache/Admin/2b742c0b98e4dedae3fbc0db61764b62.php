<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>  
  <title>美丽坪山后台管理</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="/favicon.ico" rel="shortcut icon">
  <link rel="stylesheet" href="<?php echo C('STATIC_URL');?>Public/admin/layui/css/layui.css">
  <link rel="stylesheet" href="<?php echo C('STATIC_URL');?>Public/admin/css/global.css?v=1">
  <script src="<?php echo C('STATIC_URL');?>Public/admin/js/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="<?php echo C('STATIC_URL');?>Public/admin/layui/layui.js" type="text/javascript"></script>
</head>
<body>
<div class="tpt—index fly-panel fly-panel-user">
<blockquote style="padding: 10px;border-left: 5px solid #009688;" class="layui-elem-quote">系统信息：</blockquote>
<table width="100%">
	<tr><td>服务器类型</td><td><?php echo php_uname('s');?></td></tr>
	<tr><td>PHP版本</td><td><?php echo PHP_VERSION;?></td></tr>
	<tr><td>Zend版本</td><td><?php echo Zend_Version();?></td></tr>
	<tr><td>服务器解译引擎</td><td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td></tr>
	<tr><td>服务器语言</td><td><?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];?></td></tr>
	<tr><td>服务器Web端口</td><td><?php echo $_SERVER['SERVER_PORT'];?></td></tr>
</table>

</div>
<div class="footer">
</div>
<script>
layui.use(['layer','jquery'], function(){
  var layer = layui.layer
  ,jq = layui.jquery;

  jq('.logi_logout').click(function(){
    loading = layer.load(2, {
      shade: [0.2,'#000']
    });
    jq.getJSON('<?php echo U("login/logout");?>',function(data){
      if(data.code == 200){
        layer.close(loading);
        layer.msg(data.msg, {icon: 1, time: 1000}, function(){
          location.reload();
        });
      }else{
        layer.close(loading);
        layer.msg(data.msg, {icon: 2, anim: 6, time: 1000});
      }
    });
  });

})
</script>
</body>
</html>