<?php
if(!isset($_SESSION)){
	session_start();
}
define('root', $_SERVER["DOCUMENT_ROOT"]);


require_once root . '/LaneWeChat/config.php';
if (!isset($_GET['code'])) {
	die('code error!');
}
$code = $_GET['code'];
$openId = \LaneWeChat\Core\WeChatOAuth::getAccessTokenAndOpenId($code);

//file_put_contents($_SERVER["DOCUMENT_ROOT"].'/log/openId['.date('Y-m-d').']'.time(), var_export($openId,1));

//$wxUser = \LaneWeChat\Core\UserManage::getUserInfo($openId['openid']);####这个需要普通的access_token,耗子巨大
$wxUser = \LaneWeChat\Core\WeChatOAuth::getUserInfo($openId['access_token'], $openId['openid']);
//file_put_contents($_SERVER["DOCUMENT_ROOT"].'/log/wxUser['.date('Y-m-d').']'.time(), var_export($wxUser,1));

//用户没有授权将不会获取到微信用户基本信息
if( !(isset($wxUser['errcode']) && $wxUser['errcode'] > 0) ){
	foreach ($wxUser as $key => $value) {
		$_SESSION['wxapp'][$key] = $value;
	}
}



switch (intval($_SESSION['appconfig']['appmode'])) {
	case 0:
		# 强制关注 || 调出授权窗口
		/*
		if ($_SESSION['wxapp']['subscribe'] == 0) {
			header("location: ".trim($wxConfig['appurl']));
			die;
		}
		*/
		break;
	case 1:
		# 无需关注 || 静默接入微信
		
		$_SESSION['wxapp']["openid"]=$openId['openid'];
	    $_SESSION['wxapp']["nickname"]="编辑名字";
	    $_SESSION['wxapp']["sex"]=1;
	    $_SESSION['wxapp']["language"]="zh_CN";
	    $_SESSION['wxapp']["city"]="吉安";
	    $_SESSION['wxapp']["province"]="江西";
	    $_SESSION['wxapp']["country"]="中国";
	    $_SESSION['wxapp']["headimgurl"]="css/img/default.jpg";
	    $_SESSION['wxapp']["remark"]=0;

		break;
	default:
		# wap
		# 不会运行到这里来的
		break;	
}
//如果没有关注，将跳转到关注页面!

if (isset($_GET['backurl'])) {
	header("location: " . urldecode($_GET['backurl']));
} else {
	die('请正确配置好微信平台信息，确认你的是认证的微信服务号!');
}
?>