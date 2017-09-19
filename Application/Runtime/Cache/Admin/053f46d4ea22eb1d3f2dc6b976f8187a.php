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
<div class="fly-panel fly-panel-user">
<div class="tpt—admin">
<form class="layui-form">
  <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
  <input type="hidden" name="act" value="<?php echo ($act); ?>">
 <div class="layui-form-item">
    <label class="layui-form-label">月份</label>
    <div class="layui-input-block" style="width: 100px;">
       <select name="month" lay-verify="required" lay-search="">
          <option value="">全部</option>
          <option value="1"  <?php if($info["month"] == 1): ?>selected<?php endif; ?>>1月</option>
          <option value="2"  <?php if($info["month"] == 2): ?>selected<?php endif; ?>>2月</option>
          <option value="3"  <?php if($info["month"] == 3): ?>selected<?php endif; ?>>3月</option>
          <option value="4"  <?php if($info["month"] == 4): ?>selected<?php endif; ?>>4月</option>
          <option value="5"  <?php if($info["month"] == 5): ?>selected<?php endif; ?>>5月</option>
          <option value="6"  <?php if($info["month"] == 6): ?>selected<?php endif; ?>>6月</option>
          <option value="7"  <?php if($info["month"] == 7): ?>selected<?php endif; ?>>7月</option>
          <option value="8"  <?php if($info["month"] == 8): ?>selected<?php endif; ?>>8月</option>
          <option value="9"  <?php if($info["month"] == 9): ?>selected<?php endif; ?>>9月</option>
          <option value="10"  <?php if($info["month"] == 10): ?>selected<?php endif; ?>>10月</option>
          <option value="11"  <?php if($info["month"] == 11): ?>selected<?php endif; ?>>11月</option>
          <option value="12"  <?php if($info["month"] == 12): ?>selected<?php endif; ?>>12月</option>
        </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">主题</label>
    <div class="layui-input-block">
      <input type="text" name="title" value="<?php echo ($info['title']); ?>" required lay-verify="required" placeholder="请输入内容" autocomplete="off" class="layui-input">
    </div>
  </div>	
  
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">描述</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入描述" class="layui-textarea" name="content"><?php echo ($info["content"]); ?> </textarea>
    </div>
	<div class="layui-form-mid layui-word-aux"></div>
  </div>
   
  <div class="layui-form-item">
    <div class="layui-input-block">
	  <button class="layui-btn" lay-submit="" lay-filter="submit_add">立即提交</button>
      <button class="layui-btn layui-btn-primary" onclick="history.go(-1)">返回</button>
    </div>
  </div>

</form>
<script>
layui.use(['form', 'upload'],function(){
  var form = layui.form()
  ,jq = layui.jquery;
  
  layui.upload({
    url: '<?php echo U("Action/upload");?>'
    ,elem:'#image'
    ,before: function(input){
      loading = layer.load(2, {
        shade: [0.2,'#000']
      });
    }
    ,success: function(res){
      layer.close(loading);
	  var picurl = '/upload/'+res.path;
      jq('input[name=pic]').val(picurl);
	  $('#showpic').attr('src',picurl).show();
      layer.msg(res.message, {icon: 1, time: 1000});
    }
  }); 
  
  form.on('submit(submit_add)', function(data){
    loading = layer.load(2, {
      shade: [0.2,'#000']
    });
    var param = data.field;
    jq.post('<?php echo U("topic/add");?>',param,function(data){
      if(data.code == 200){
        layer.close(loading);
        layer.msg(data.msg, {icon: 1, time: 1000}, function(){
          location.href = data.backurl;
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