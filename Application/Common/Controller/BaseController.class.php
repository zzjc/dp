<?php
namespace Common\Controller;
use Think\Controller;
use Think\Cache\Driver\WXRedis;
/**
* 公用基类
*/


class BaseController extends Controller{

    public function _initialize() {//全局变量

		define('IS_WEIXIN',is_weixin());
		/*if(IS_WEIXIN){
			 //定义微信
			 define('WECHAT_APPID',C('WX_APPID'));
			 define('WECHAT_APPSECRET',C('WX_SECRET'));	
			 
			 $callbackUrl = getCurUrl();
			 //session('openid',null);
			 if(session('openid')==''){
			 	$code = I("request.code");
			 	$WeChatOauth =   '\Common\Library\LaneWechat\core\WeChatOauth';  
					if($code!=''){ //获取openid
						$result=$WeChatOauth::getAccessTokenAndOpenId($code);
						
						//用户是否存在
						$uinfo = $this->getMember($result['openid']);
						if(!empty($uinfo)){
							session('openid',$uinfo['openid']);
							session('nickname',$uinfo['nickname']);	
							session('headimgurl',$uinfo['headimgurl']);	
						}else{
							$userInfo=$WeChatOauth:: getUserInfo($result['access_token'], $result['openid']);
							if($userInfo){  
					 			$uinfo = $this->addMember($userInfo);
								session('openid',$userInfo['openid']);
								session('nickname',$userInfo['nickname']);
								session('headimgurl',$userInfo['headimgurl']);	

							}else{
								die('获取信息出错！请联系客服人员！谢谢！');
						 	}
						}
						session('openid',$result['openid']);
						header("Location:".$callbackUrl);	

					}else{	
						//已授权的跳转
						$WeChatOauth::getCode($callbackUrl,1,'snsapi_userinfo');
					}
			 }
			 
			 //printarray(session());

			 $this->openid = session('openid');
			 $this->nickname = session('nickname');
			 
		}*/
		if(getenv('DP_ENVIRONMENT_MAIN') == 'develop'){ 
			session('openid',$userInfo['openid']);
		    $this->openid = 'jfjsadfjasdjfadfzxx11';
			$this->nickname = 'jimmy';
			session('openid',$this->openid);
			session('nickname',$this->nickname);
			session('headimgurl','http://wx.qlogo.cn/mmopen/YKopDRiagalD39J7xAHEGzEibHUpbncUmXicicSNMDuiaUicV19TicibTnicTjwc4SibfBLu0ut83ckB90JdwrnDj6HBTkRegWfuegzO0J/0');	
			$this->assign('openid' ,$this->openid);
		}

		if($this->openid==''){
			header("Content-Type: text/html;charset=utf-8"); 
			exit('请在微信上参加活动！');
		}
		
		$this->assign('is_weixin' ,IS_WEIXIN);		
    }


   public function getMember($openid){
   		$conditon['openid'] = $openid;
		$userInfo = M('member')->where($conditon)->field('openid,nickname,headimgurl')->find();
		return $userInfo;
   }


   public function addMember($userInfo){
   		$data['nickname']  = $userInfo['nickname']?$userInfo['nickname']:'';
        $data['openid']    = $userInfo['openid'];
        $data['unionid']  = $userInfo['unionid']?$userInfo['unionid']:'';
        $data['headimgurl']   = $userInfo['headimgurl'];
        $data['sex']   = $userInfo['sex'];
        $data['addtime']     =time();
        $data['id'] = M('member')->add($data);
	}
   

   	/**
	 * @Author:      zhanchengbin
	 * @DateTime:    2017-01-09
	 * @Description:  redis 锁住某个操作
	 */
	public function redisLock($mark, $expire = 1){
		$url = strtolower(CONTROLLER_NAME . '/' . ACTION_NAME);//操作地址
		$prefix = 'lock_';
		$key = $prefix . md5($url . $mark);//令牌键值
		if (WXRedis::incr($key) == 1) {
			return WXRedis::expire($key, $expire);
		}

		return false;
	}


	/**
	 * @Author:      zhanchengbin
	 * @DateTime:    2017-01-09
	 * @Description:  redis 解锁请求
	 */
	public function redisUnlock($mark){
		$url = strtolower(CONTROLLER_NAME . '/' . ACTION_NAME);//操作地址
		$prefix = 'lock_';
		$key = $prefix . md5($url . $mark);//令牌键值
		return WXRedis::del($key);
	}
    
}