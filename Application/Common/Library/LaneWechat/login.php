<?php
require_once dirname(__FILE__).'/lanewechat.php'; 
 
 if(empty($_SESSION['openid'])){
  	$code =$_GET['code'];
	if($code!=''){ //获取openid

		$back_url ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

		$result=\LaneWeChat\Core\WeChatOAuth::getAccessTokenAndOpenId($code);
		//用户是否存在
		//print_r($result);die;
		$info = checkMember($result['openid']);
		if($info!=''){	
			$_SESSION['openid'] = $info['username'];
			$_SESSION['nickname'] = $info['alias'];
			$_SESSION['headimg'] = $info['headimg'];
		}else{
			$UserInfoinfo=\LaneWeChat\Core\WeChatOAuth:: getUserInfo($result['access_token'], $result['openid']);
	 		if($UserInfoinfo != null){  
	 			addMember($UserInfoinfo['openid'], $UserInfoinfo['nickname'], $UserInfoinfo['headimgurl']);
				$_SESSION['openid'] = $UserInfoinfo['openid'];
				$_SESSION['nickname'] = $UserInfoinfo['nickname'];
				$_SESSION['headimg'] = $UserInfoinfo['headimgurl'];
					
			}else{
				die('获取信息出错！请联系本司客服人员！谢谢！');
		 	}
		}
		header("Location:".$back_url);	
		
	}else{	
		//已授权的跳转
		$redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		\LaneWeChat\Core\WeChatOAuth::getCode($redirect_uri,1,'snsapi_userinfo');
	}
   
}
	
?>