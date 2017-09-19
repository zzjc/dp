<?
include 'lanewechat.php';
$host_url="http://".$_SERVER['HTTP_HOST'];
  //设置菜单

/*1 ==》 点单
2 ==》我的=》①历史订单②地址管理③商品菜单
3 ==》意见反馈   */

$menuList = array(
    array('id'=>'1', 'pid'=>'',  'name'=>'点单', 'type'=>'view', 'code'=>$host_url.'/order.php'),
    array('id'=>'2', 'pid'=>'',  'name'=>'我的', 'type'=>'', 'code'=>''),
    array('id'=>'3', 'pid'=>'2',  'name'=>'历史订单', 'type'=>'view','code'=>$host_url.'/history.php'),
    array('id'=>'4', 'pid'=>'2',  'name'=>'地址管理', 'type'=>'view', 'code'=>$host_url.'/adress.php'),
    array('id'=>'5', 'pid'=>'2',  'name'=>'商品菜单', 'type'=>'view', 'code'=>$host_url.'/product.php'),
    array('id'=>'6', 'pid'=>'',  'name'=>'意见反馈', 'type'=>'view', 'code'=>$host_url.'/opinion.php'),
);

\LaneWeChat\Core\Menu::setMenu($menuList);
?>