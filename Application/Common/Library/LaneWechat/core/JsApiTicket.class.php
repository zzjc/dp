<?php
namespace Common\Library\LaneWechat\core;
/**
 * 微信Access_Token的获取与过期检查
 * Created by Lane.
 * User: lane
 * Date: 13-12-29
 * Time: 下午5:54
 * Mail: lixuan868686@163.com
 * Website: http://www.lanecn.com
 */
class JsApiTicket{

    /**
     * 获取微信Access_Token
     */
    public static function getJsApiTicket(){
        //检测本地是否已经拥有access_token，并且检测access_token是否过期
        $jsApiTicket = self::_checkJsApiTicket();
        if($jsApiTicket === false){
            $jsApiTicket = self::_getJsApiTicket();
        }
        return $jsApiTicket['ticket'];
    }

    /**
     * @descrpition 从微信服务器获取微信ACCESS_TOKEN
     * @return Ambigous|bool
     */
    private static function _getJsApiTicket(){
        $accessToken = AccessToken::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
        $jsApiTicket = Curl::callWebServer($url, '', 'GET');

        if(!isset($jsApiTicket['ticket'])){
            //return Msg::returnErrMsg(MsgConstant::ERROR_GET_ACCESS_TOKEN, $jsApiTicket['errcode'].':'.$jsApiTicket['errmsg']);
            file_put_contents($_SERVER["DOCUMENT_ROOT"].'/log/jsapiticket['.date('Y-m-d').']'.time(), var_export($jsApiTicket['errcode'].':'.$jsApiTicket['errmsg'].':'.$url,1));
            die;
            //return false;
        }
        $jsApiTicket['time'] = time();
        $jsApiTicketJson = json_encode($jsApiTicket);
        //存入数据库
        /**
         * 这里通常我会把access_token存起来，然后用的时候读取，判断是否过期，如果过期就重新调用此方法获取，存取操作请自行完成
         *
         * 请将变量$jsApiTicketJson给存起来，这个变量是一个字符串
         */
        //$f = fopen('access_token', 'w+');
        //fwrite($f, $jsApiTicketJson);
        //fclose($f);
          file_put_contents($_SERVER["DOCUMENT_ROOT"].'/log/data/jsTicket.json',$jsApiTicketJson);
        return $jsApiTicket;
    }

    /**
     * @descrpition 检测微信ACCESS_TOKEN是否过期
     *              -10是预留的网络延迟时间
     * @return bool
     */
    private static function _checkJsApiTicket(){
        //获取access_token。是上面的获取方法获取到后存起来的。
//        $jsApiTicket = YourDatabase::get('access_token');
        //$data = file_get_contents('access_token');
        $jsApiTicketJson = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/log/data/jsTicket.json');
        $jsApiTicket = json_decode($jsApiTicketJson,true);
  
         if(!empty($jsApiTicket['ticket'])){
            if(time() < $jsApiTicket['expires_in']+$jsApiTicket['time']-10 ){
                return $jsApiTicket;
            }
        }

        return false;
    }
}
?>