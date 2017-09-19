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

<div class="layui-inline">
<a href="<?php echo U('question/add');?>"><button class="layui-btn"><i class="layui-icon">&#xe608;</i> 添加题目</button></a>
</div>
<div style="float: right;" class="layui-form-item">
<form class="layui-form" action="" method="get">
<div class="layui-inline">
      <label class="layui-form-label">关键字</label>
      <div class="layui-input-inline">
        <input placeholder="输入关键字" name="keyword" value="<?php echo ($_GET['keyword']); ?>" type="text" class="layui-input" style="float: left;margin-right: 10px;width: 180px;">
      </div>
      <div class="layui-form-label">月份</div>
       <div class="layui-input-inline" style="width: 100px;">
        <select name="month" lay-verify="required" lay-search="">
          <option value="">全部</option>
          <option value="1" <?php if($_GET['month']== 1): ?>selected<?php endif; ?>>1月</option>
          <option value="2" <?php if($_GET['month']== 2): ?>selected<?php endif; ?>>2月</option>
          <option value="3" <?php if($_GET['month']== 3): ?>selected<?php endif; ?>>3月</option>
          <option value="4" <?php if($_GET['month']== 4): ?>selected<?php endif; ?>>4月</option>
          <option value="5" <?php if($_GET['month']== 5): ?>selected<?php endif; ?>>5月</option>
          <option value="6" <?php if($_GET['month']== 6): ?>selected<?php endif; ?>>6月</option>
          <option value="7" <?php if($_GET['month']== 7): ?>selected<?php endif; ?>>7月</option>
          <option value="8" <?php if($_GET['month']== 8): ?>selected<?php endif; ?>>8月</option>
          <option value="9" <?php if($_GET['month']== 9): ?>selected<?php endif; ?>>9月</option>
          <option value="10" <?php if($_GET['month']== 10): ?>selected<?php endif; ?>>10月</option>
          <option value="11" <?php if($_GET['month']== 11): ?>selected<?php endif; ?>>11月</option>
          <option value="12" <?php if($_GET['month']== 12): ?>selected<?php endif; ?>>12月</option>
        </select>
      </div>
	  <button class="layui-btn" style="float: left;" value="查询" type="submit">查询</button>
    </div>
</form>
</div>

<form class="layui-form">
<table width="100%">
<tr>
<th width="5%" align="center"><input type="checkbox" name="checkAll" lay-filter="checkAll"></th>
<th width="5%" align="center">ID</th>
<th width="50%" align="center">题目</th>
<th width="10%" align="center">月份</th>
<th width="10%" align="center">排序</th>
<th width="10%" align="center">时间</th>
<th width="10%" align="center">基本操作</th>
</tr>
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
<td align="center"><input type="checkbox" name="ids[<?php echo ($vo["id"]); ?>]" lay-filter="checkOne" value="<?php echo ($vo["id"]); ?>"></td>
<td align="center"><?php echo ($vo["id"]); ?></td>
<td style="padding-left: 20px;"><?php echo ($vo["title"]); ?></td>

<td align="center"><?php echo ($vo["month"]); ?></td>
<td align="center"><input type="text" name="sorts[<?php echo ($vo["id"]); ?>]"   class="layui-input" style="width:45px" value="<?php echo ($vo["sort"]); ?>"></td>
<td align="center"><?php echo (date("Y-m-d",$vo["addtime"])); ?></td>
<td align="center">
<a class="layui-btn layui-btn-mini layui-btn-warm" href="<?php echo U('question/add',array('id'=>$vo['id'],'act'=>'edit'));?>">修改</a> <a class="layui-btn layui-btn-mini layui-btn-danger del_btn" member-id="<?php echo ($vo["id"]); ?>" title="删除" nickname="<?php echo ($vo["title"]); ?>">删除</a>
</td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<div class="layui-form-item">
<div style="margin-top: 20px;float: left;">
<button class="layui-btn layui-btn-danger" lay-submit lay-filter="delete">删除选中</button>
<button class="layui-btn layui-btn-normal" lay-submit lay-filter="sort">更新排序</button>
</div>
<div class="pages" style="float: right;"><?php echo ($page); ?></div>
</div>
</form>

<script>
layui.use('form',function(){
  var form = layui.form()
  ,jq = layui.jquery;

  jq('.del_btn').click(function(){
    var name = jq(this).attr('nickname');
    var id = jq(this).attr('member-id');
    layer.confirm('确定删除【'+name+'】?', function(index){
      loading = layer.load(2, {
        shade: [0.2,'#000']
      });
      jq.post('<?php echo U("question/dels");?>',{'id':id},function(data){
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
  });

  form.on('checkbox(checkAll)', function(data){
    if(data.elem.checked){
      jq("input[type='checkbox']").prop('checked',true);
    }else{
      jq("input[type='checkbox']").prop('checked',false);
    }
    form.render('checkbox');
  });  

  form.on('checkbox(checkOne)', function(data){
    var is_check = true;
    if(data.elem.checked){
      jq("input[lay-filter='checkOne']").each(function(){
        if(!jq(this).prop('checked')){ is_check = false; }
      });
      if(is_check){
        jq("input[lay-filter='checkAll']").prop('checked',true);
      }
    }else{
      jq("input[lay-filter='checkAll']").prop('checked',false);
    } 
    form.render('checkbox');
  });

  form.on('submit(delete)', function(data){
    var is_check = false;
    jq("input[lay-filter='checkOne']").each(function(){
      if(jq(this).prop('checked')){ is_check = true; }
    });
    if(!is_check){
      layer.msg('请选择数据', {icon: 2,anim: 6,time: 1000});
      return false;
    }
    layer.confirm('确定批量删除?', function(index){
      loading = layer.load(2, {
        shade: [0.2,'#000']
      });
      var param = data.field;
      jq.post('<?php echo U("question/delss");?>',param,function(data){
        if(data.code == 200){
          layer.close(loading);
          layer.msg(data.msg, {icon: 1, time: 1000}, function(){
            location.reload();
          });
        }else{
          layer.close(loading);
          layer.msg(data.msg, {icon: 2,anim: 6, time: 1000});
        }
      });
    });
    return false;
  });
  
  form.on('submit(sort)', function(data){
  
    layer.confirm('确定调整排序吗?', function(index){
      loading = layer.load(2, {
        shade: [0.2,'#000']
      });
	  console.log(data);
      var param = data.field;
      jq.post('<?php echo U("question/sorts");?>',param,function(data){
        if(data.code == 200){
          layer.close(loading);
          layer.msg(data.msg, {icon: 1, time: 1000}, function(){
            location.reload();
          });
        }else{
          layer.close(loading);
          layer.msg(data.msg, {icon: 2,anim: 6, time: 1000});
        }
      });
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