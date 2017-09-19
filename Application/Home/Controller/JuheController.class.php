<?php
namespace Home\Controller;
use Think\Controller;
class JuheController extends Controller {   

     /**
     * 回调
     */
    private $chargekey;
    private $openid;

    //话费url
    private $telCheckUrl = 'http://op.juhe.cn/ofpay/mobile/telcheck';
    private $telQueryUrl = 'http://op.juhe.cn/ofpay/mobile/telquery';
    private $submitUrl = 'http://op.juhe.cn/ofpay/mobile/onlineorder';
    private $staUrl = 'http://op.juhe.cn/ofpay/mobile/ordersta';


    //流量url
    private $telCheckUrl = 'http://op.juhe.cn/ofpay/mobile/telcheck';
    private $telQueryUrl = 'http://op.juhe.cn/ofpay/mobile/telquery';
    private $submitUrl = 'http://op.juhe.cn/ofpay/mobile/onlineorder';
    private $staUrl = 'http://op.juhe.cn/ofpay/mobile/ordersta';
    
    
    public function _initialize($chargekey,$openid){
        $this->chargekey = 'ddae7f2462080b516db1e812b7836bcf';
        $this->flowkey = 'fa02d6db518cbe2082c570457e77d531';
        $this->openid = 'JH8baefb37a28d892c5673a2a25fcbabf0';
    }
 
    /**
     * 根据手机号码及面额查询是否支持充值
     * @param  string $mobile   [手机号码]
     * @param  int $pervalue [充值金额]
     * @return  boolean
     */
    public function telcheck($mobile,$pervalue){
        $params = 'key='.$this->chargekey.'&phoneno='.$mobile.'&cardnum='.$pervalue;
        $content = $this->juhecurl($this->telCheckUrl,$params);
        $result = $this->_returnArray($content);
        if($result['error_code'] == '0'){
            return true;
        }else{
            return false;
        }
    }
 
    /**
     * 根据手机号码和面额获取商品信息
     * @param  string $mobile   [手机号码]
     * @param  int $pervalue [充值金额]
     * @return  array
     */
    public function telquery($mobile,$pervalue){
        $params = 'key='.$this->chargekey.'&phoneno='.$mobile.'&cardnum='.$pervalue;
        $content = $this->juhecurl($this->telQueryUrl,$params);
        return $this->_returnArray($content);
    }
 
    /**
     * 提交话费充值
     * @param  [string] $mobile   [手机号码]
     * @param  [int] $pervalue [充值面额]
     * @param  [string] $orderid  [自定义单号]
     * @return  [array]
     */
    public function telcz($mobile,$pervalue,$orderid){
        $sign = md5($this->openid.$this->chargekey.$mobile.$pervalue.$orderid);//校验值计算
        $params = array(
            'key' => $this->chargekey,
            'phoneno'   => $mobile,
            'cardnum'   => $pervalue,
            'orderid'   => $orderid,
            'sign' => $sign
        );
        $content = $this->juhecurl($this->submitUrl,$params,1);
         return $this->_returnArray($content);
    }
 
    /**
     * 查询订单的充值状态
     * @param  [string] $orderid [自定义单号]
     * @return  [array]
     */
    public function sta($orderid){
        $params = 'key='.$this->chargekey.'&orderid='.$orderid;
        $content = $this->juhecurl($this->staUrl,$params);
        return $this->_returnArray($content);
    }
 
    /**
     * 将JSON内容转为数据，并返回
     * @param string $content [内容]
     * @return array
     */
    public function _returnArray($content){
        return json_decode($content,true);
    }
 
    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    public function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
 
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
    

    public function callback(){
        $chargekey = C('JUHE_KEY'); //您申请的数据的APIKey
        $sporder_id = addslashes($_POST['sporder_id']); //聚合订单号
        $orderid = addslashes($_POST['orderid']); //商户的单号
        $sta = addslashes($_POST['sta']); //充值状态
        $sign = addslashes($_POST['sign']); //校验值
         
        $local_sign = md5($chargekey.$sporder_id.$orderid); //本地sign校验值
         
        if ($local_sign == $sign) {
            $map['orderid'] =  $orderid;    
            if ($sta == '1') {
                $data['status'] =1;
                M('order')->where($map)->save($data);
            } elseif ($sta =='9') {
                //充值失败,根据自身业务逻辑进行后续处理
            }
        }

    }

    

}