<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>美丽坪山后台管理系统</title>
<link rel="stylesheet" href="<?php echo C('STATIC_URL');?>Public/admin/css/admin.css">
<link rel="stylesheet" href="<?php echo C('STATIC_URL');?>Public/admin/layui/css/layui.css">
<script src="<?php echo C('STATIC_URL');?>Public/admin/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php echo C('STATIC_URL');?>Public/admin/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo C('STATIC_URL');?>Public/admin/layui/layui.js" type="text/javascript"></script>
</head>
<body id="login">
<div class="login">
<h2>美丽坪山后台管理</h2>
<form class="layui-form">
<div class="layui-form-item">
<input type="text" name="username" placeholder="请输入账号" required lay-verify="required" autocomplete="off" class="layui-input">
</div>
<div class="layui-form-item">
<input type="password" name="password" placeholder="请输入密码" required lay-verify="required" autocomplete="off" class="layui-input">
</div>
<div class="layui-form-item">
<input style="width:100px;float:left;margin-right: 10px;" type="text" name="code" placeholder="验证码" required lay-verify="required" autocomplete="off" class="layui-input">
<img src="<?php echo U('Login/createVerify');?>" onclick="this.src='<?php echo U('Login/createVerify');?>/v/'+Math.random();" width="150" style="float:left; cursor:pointer;" alt="captcha" />
</div>
<div class="layui-form-item">
<button style="padding: 0 102px;" class="layui-btn" lay-submit="" lay-filter="login_index">立即登录</button>
</div>
</form>
<script>
layui.use('form',function(){
  var form = layui.form()
  ,jq = layui.jquery;

  form.on('submit(login_index)', function(data){
    loading = layer.load(2, {
      shade: [0.2,'#000']
    });
    var param = data.field;
    jq.post('<?php echo U("login/index");?>',param,function(data){
      if(data.code == 200){
        layer.close(loading);
        layer.msg(data.msg, {icon: 1, time: 1000}, function(){
          location.href = '<?php echo U("index/index");?>';
        });
      }else{
        layer.close(loading);
        layer.msg(data.msg, {icon: 2, anim: 6, time: 1000});
      }
    });
    return false;
  });

})
</script>
</div>
</body>
</html>