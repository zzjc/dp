<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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
<style type="text/css">
.layui-nav-tree .layui-this{background-color: #393D49;color: #fff;}
</style>
<div class="header">
  <div class="main">
    <a href="<?php echo U('index/index');?>" title=""  class="my-header-logo"><i class="layui-icon" style="font-size: 28px; color:#009688">&#xe632;</i> 后台管理</a>

		<ul class="layui-nav" lay-filter="" >
		  <!-- 	
		  <li class="layui-nav-item"><a href="">最新活动</a></li>
		  <li class="layui-nav-item layui-this"><a href="">产品</a></li>
		  <li class="layui-nav-item"><a href="">大数据</a></li>
		  -->
		  <li class="layui-nav-item">
			<a href="javascript:;"><?php echo session('username');?></a>
			<dl class="layui-nav-child"> <!-- 二级菜单 -->
			  <dd><a class="update_cache">清理缓存</a></dd>
			  <dd><a class="logi_logout" href="javascript:void(0)">退出</a></dd>
			</dl>
		  </li>
		</ul>

  </div>
</div>

<div class="main fly-user-main layui-clear">
<ul class="layui-nav layui-nav-tree left_menu_ul" lay-filter="side-top-left">
	<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="layui-nav-item layui-nav-itemed">
    <a href="javascript:;"><i class="layui-icon"><?php echo ($vo["icon"]); ?></i><?php echo ($vo["tit"]); ?></a>
    <dl class="layui-nav-child">
	  	<?php if(is_array($vo["sub"])): $i = 0; $__LIST__ = $vo["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?><dd><a href-url="<?php echo ($sub["url"]); ?>" target="main"><?php echo ($sub["tit"]); ?></a></dd><?php endforeach; endif; else: echo "" ;endif; ?>
    </dl>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
	
</ul>
</div>

<div class="layui-body my-body iframe-container">	
<div class="layui-tab layui-tab-card my-tab " lay-filter="card" lay-allowclose="true">
  <ul class="layui-tab-title">
    <li class="layui-this" lay-id="1">首页</li>
    
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">
	<iframe class="admin-iframe" id="admin-iframe" name="main" src="<?php echo U('index/home');?>"></iframe>
	</div>
   
  </div>
</div>

</div>
<script type="text/javascript">
layui.use(['layer', 'element','jquery'], function(){
  var layer = layui.layer
  ,element = layui.element()
  ,jq = layui.jquery;
  
  
  
  
  jq('.left_menu_ul .layui-nav-item').click(function(){
    jq('.left_menu_ul .layui-nav-item').removeClass('layui-this');
    jq(this).addClass('layui-this');
    jq("#iframe-mask").show();
    jq("#admin-iframe").load(function(){   
      jq("#iframe-mask").fadeOut(100);
    });
  });

  jq('.update_cache').click(function(){
    loading = layer.load(2, {
      shade: [0.2,'#000']
    });
    jq.getJSON('<?php echo U("index/update");?>',function(data){
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
  
  
    // 监听顶部左侧导航
    element.on('nav(side-top-left)', function (elem) {
        console.log(elem);
        // 添加tab方法
        window.addTab(elem);
    });
	
	  // 根据导航栏text获取lay-id
    function getTitleId(card, title) {
        var id = -1;
        $(document).find(".layui-tab[lay-filter=" + card + "] ul li").each(function () {
            if (title === $(this).find('span').html()) {
                id = $(this).attr('lay-id');
            }
        });
        return id;
    };

    // 添加TAB选项卡
    window.addTab = function (elem, tit, url) {
        var card = 'card';                                           // 选项卡对象
        var title = tit ? tit : elem.children('a').html();            // 导航栏text
        var src = url ? url : elem.children('a').attr('href-url');  // 导航栏跳转URL
        var id = new Date().getTime();                             // ID
        var flag = getTitleId(card, title);                          // 是否有该选项卡存在
        // 大于0就是有该选项卡了
        if (flag > 0) {
            id = flag;
        } else {
            if (src) {
                //新增
                element.tabAdd(card, {
                    title: '<span>' + title + '</span>'
                    , content: '<iframe class="admin-iframe" id="admin-iframe" name="main" src="' + src + '"></iframe>'
                    , id: id
                });
                // 关闭弹窗
                layer.closeAll();
            }
        }
        // 切换相应的ID tab
        element.tabChange(card, id);
        // 提示信息
        // layer.msg(title);
    };
});
</script>
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