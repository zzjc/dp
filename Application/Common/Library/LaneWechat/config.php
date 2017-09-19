<?php
namespace LaneWeChat;
if(!isset($_SESSION)){
	session_start();
}
/**
 * 系统主配置文件.
 * @Created by Lane.
 * @Author: lane
 * @Mail lixuan868686@163.com
 * @Date: 14-8-1
 * @Time: 下午1:00
 * @Blog: Http://www.lanecn.com
 */
header("content-type:text/html;charset=utf8");
if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/setting.php')){
	file_put_contents($_SERVER["DOCUMENT_ROOT"].'/setting.php', '<?php ?>');
}
require_once($_SERVER["DOCUMENT_ROOT"].'/setting.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/xshop/config.php');
//引入全局
$_SESSION['appconfig']  = SETTING();



//设定推荐人ID缓存
if(isset($_GET['fromUser'])){
	if($_SESSION['appconfig']['fronUserCookieDate']==0){
		$_SESSION['appconfig']['fronUserCookieDate'] = 1;
	}
	setcookie("fromUser",addslashes($_GET['fromUser']), time()+3600*24*intval($_SESSION['appconfig']['fronUserCookieDate']));
}


//引入店主自定义设置 2015/06/08日升级

///$_GET['adminid'] 返回的时候参数将不复存在,需要解析返回参数的backurl

$adminid = isset($_GET['adminid'])?$_GET['adminid']:$_SESSION['appconfig']['shopadmin']['id'];

if( $adminid==0 && isset($_GET['backurl']) ){
	
	$url = urldecode($_GET['backurl']);
	$url = explode('?', $url);
	if(!is_array($url)){
		exit('解析微信返回URL错误');
	}
	$url = explode('&', $url[1]);
	if(!is_array($url)){
		exit('解析微信返回URL的参数错误');
	}
	$ret = array();
	
	foreach ($url as $v) {
		$ret = explode('=', $v);
		if(in_array('adminid', $ret)) {
			foreach ($ret as $kk => $vv) {
				if(intval($vv)>0){
					$adminid = $vv;
					break;
				}
			}
			break;
		}
	}
	unset($ret);
	unset($url);
}



$_SESSION['appconfig']['shopadmin'] = isset($_SESSION['appconfig']['shopadmin'])?$_SESSION['appconfig']['shopadmin'] : getAdmin(intval($adminid));

//file_put_contents($_SERVER["DOCUMENT_ROOT"].'/log/admin-'.time(), var_export($_SESSION['appconfig']['shopadmin'],1));
//file_put_contents($_SERVER["DOCUMENT_ROOT"].'/log/url-'.time(), 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);


//自定义的接入
//appmode {0:'显示授权窗口',1:'不显示，静默接入'}
if($_SESSION['appconfig']['shopadmin'] ){

	//自定义接入
	if($_SESSION['appconfig']['shopadmin']['usedefaultapp']==0){
		$wxConfig['zy-sign'] = "自定义接入";
		$wxConfig['appmode'] = $_SESSION['appconfig']['appmode'] = $_SESSION['appconfig']['shopadmin']['subscibe'];
	    $wxConfig['appid'] = $_SESSION['appconfig']['appid'] = $_SESSION['appconfig']['shopadmin']['appid'];
	    $wxConfig['appsecret'] = $_SESSION['appconfig']['appsecret'] = $_SESSION['appconfig']['shopadmin']['appsecret'];
	    $wxConfig['apptoken'] = $_SESSION['appconfig']['apptoken'] = $_SESSION['appconfig']['shopadmin']['apptoken'];
	    $wxConfig['appurl'] = $_SESSION['appconfig']['appurl'] = $_SESSION['appconfig']['shopadmin']['appurl'];
	    $wxConfig['appaes'] = $_SESSION['appconfig']['appaes'] = $_SESSION['appconfig']['shopadmin']['appaes'];
	    $wxConfig['apptplid'] = $_SESSION['appconfig']['apptplid'] = $_SESSION['appconfig']['shopadmin']['apptplid'];
	}else{
		$wxConfig['zy-sign'] = "默认接入1";
		$wxConfig['appmode'] = $_SESSION['appconfig']['appmode'];
	    $wxConfig['appid'] = $_SESSION['appconfig']['appid'];
	    $wxConfig['appsecret'] = $_SESSION['appconfig']['appsecret'];
	    $wxConfig['apptoken'] = $_SESSION['appconfig']['apptoken'];
	    $wxConfig['appurl'] = $_SESSION['appconfig']['appurl'];
	    $wxConfig['appaes'] = $_SESSION['appconfig']['appaes'];
	    $wxConfig['apptplid'] = $_SESSION['appconfig']['apptplid'];

	}
    
}else{
	$wxConfig['zy-sign'] = "默认接入2,读取不到店主信息";
	$wxConfig['appmode'] = $_SESSION['appconfig']['appmode'];
    $wxConfig['appid'] = $_SESSION['appconfig']['appid'];
    $wxConfig['appsecret'] = $_SESSION['appconfig']['appsecret'];
    $wxConfig['apptoken'] = $_SESSION['appconfig']['apptoken'];
    $wxConfig['appurl'] = $_SESSION['appconfig']['appurl'];
    $wxConfig['appaes'] = $_SESSION['appconfig']['appaes'];
    $wxConfig['apptplid'] = $_SESSION['appconfig']['apptplid'];
}



if( !( isset($wxConfig['appid']) and isset($wxConfig['appsecret'])  and isset($wxConfig['apptoken'])  and isset($wxConfig['appurl']) )  ){
	header("content-type:text/html;charset=utf8");
	die('微信服务号没有配置,不能为您提供服务');
}




//版本号
define('LANEWECHAT_VERSION', '1.4');
define('LANEWECHAT_VERSION_DATE', '2014-11-05');

/*
 * 服务器配置，详情请参考@link http://mp.weixin.qq.com/wiki/index.php?title=接入指南
 */

/*
 * 开发者配置
 */
//define('ENCODING_AES_KEY',  trim($wxConfig['appaes']));
define('WECHAT_TOKEN', trim($wxConfig['apptoken']));
define("WECHAT_APPID", trim($wxConfig['appid']));
define("WECHAT_APPSECRET", trim($wxConfig['appsecret']));




////-----引入系统所需类库-------------------
////引入错误消息类
include_once 'core/msg.lib.php';
////引入错误码类
include_once 'core/msgconstant.lib.php';
////引入CURL类
include_once 'core/curl.lib.php';
//
////-----------引入微信所需的基本类库----------------
////引入微信处理中心类
include_once 'core/wechat.lib.php';
////引入微信请求处理类
include_once 'core/wechatrequest.lib.php';
////引入微信被动响应处理类
include_once 'core/responsepassive.lib.php';
////引入微信access_token类
include 'core/accesstoken.lib.php';
//
////-----如果是认证服务号，需要引入以下类--------------
////引入微信权限管理类
include_once 'core/wechatoauth.lib.php';
////引入微信用户/用户组管理类
include_once 'core/usermanage.lib.php';
////引入微信主动相应处理类
include_once 'core/responseinitiative.lib.php';
////引入多媒体管理类
include_once 'core/media.lib.php';
////引入自定义菜单类
include_once 'core/menu.lib.php';
?>