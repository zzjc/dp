<?php
 // 对字符型字符串加转义符
   function myAddslashes($str) {    
        if (get_magic_quotes_gpc()){
            $str = stripslashes($str);
        }
        if(is_string($str)) {           
            $str = mysql_escape_string($str);
        }elseif(is_null($str)){
            $str   =  null;
        }
        return $str;
    }


/**
 *
 * @param string $errno 错误号
 * @param string $msg 错误提示
 * @param number $status
 * @return multitype:string unknown number
 */
function errormsg($errno, $msg = '', $status = 0){
    $errmsg = array('errno' => $errno, 'msg' => $msg);
    $returnData ["errmsg"] = $errmsg;
    if ($errno < 0) {
        $returnData ["status"] = 0;
        header('Api-Error:' . $errno);
    } else {
        $returnData ["status"] = 1;
    }
    return $returnData;
}

/**
 * 输出提示
 * @param array $data
 * @param string $json
 */
function output_msg($data, $json = true){
    if ($_GET ['json'] == 'no') {
        echo "<pre>";
        print_r($data);
        exit();
    }
    if ($json === true) {
        header('Content-Type: application/json; charset=utf-8');
        $data = json_encode($data);
    }
    echo $data;
    exit();
}

//提示返回
function ajax_message($message = '', $url = ''){
    header('Content-Type: application/json; charset=utf-8');
    if (empty($url)) {
        $backurl = 'history.go(-1);';
    } else {
        $backurl = 'window.location.href="' . $url . '"';
    }
    $alt = '';
    $rel = '';
    if (!empty($message)) $alt = 'alert("' . $message . '");';
    echo '<script>' . $alt . $backurl . '</script>';
    exit;
}

/**
 * 导出excel
 * @param $strTable 表格内容
 * @param $filename 文件名
 */
function downloadExcel($strTable,$filename){
    header("Content-type: application/vnd.ms-excel");
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
    header('Expires:0');
    header('Pragma:public');
    echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$strTable.'</html>';
}



/**
 * cURL GET方式 获取远程链接内容 捕捉http重定向
 * @param string $url URL地址
 * @param int $timeout 超时时间
 * @return mixed
 */
function curl_get($url = '', $timeout = 3){
    $ch = curl_init();
    $param = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => 0,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_ENCODING => 'gzip,deflate',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,

        CURLOPT_SSL_VERIFYPEER => FALSE, // https请求 不验证证书和hosts
        CURLOPT_SSL_VERIFYHOST => FALSE,
    );
    curl_setopt_array($ch, $param);
    $rs = curl_exec($ch);
    return $rs;
}

/**
 * cURL POST方式 获取远程链接内容
 * @param string $url
 * @param array $data
 * @param int $timeout
 * @return mixed
 */
function curl_post($url = '', $data = array(), $timeout = 3, $isXml = false){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    if ($isXml) {
        //以XML格式传送
        $header[] = "Content-Type: text/xml; charset=utf-8";
    }
    //头文件
    if ($header) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/**
 * 调试日志
 * 会对数组对象做json_encode.
 * 默认文件名格式为 DEBUG_$className_$functionName_$date.log
 * @param string or object $message
 * @param string $fileName
 * @return null
 **/
function writeLog($message, $fileName = ''){
    if (is_array($message) || is_object($message))
        $message = json_encode($message);

    if (!$fileName) {
        $trace = debug_backtrace();
        if (is_array($trace)) {
            $class = $trace[1]['class'];
            $function = $trace[1]['function'];
        }
        $class = str_replace("\\", '_', $class);
        $fileName = '';
        if ($class || $function)
            $fileName .= $class . "_" . $function;
        else
            $fileName .= "log_";
    }
    //echo "<br>".$fileName;
    $fileName = $fileName . "_" . date('Ymd') . ".log";
    $destination = APP_PATH . 'Runtime/Logs/' . $fileName;
    $prefix = "[NORMAL " . date('Ymd H:i:s') . "] ";
    $suffix = "\n"; //for all
    file_put_contents($destination, $prefix . $message . $suffix, FILE_APPEND);
}

/**
 * 用正则表达式验证手机号码(中国大陆区)
 * @param integer $num 所要验证的手机号
 * @return boolean
 */
function isMobile($num){
    if (!$num) {
        return false;
    }
    return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$|^17[0-9]\d{8}$#', $num) ? true : false;
}

/**
 * 用*号代替手机号部分内容
 * @param $tel string 手机号码
 */
function replaceTelphone($tel){
    return preg_replace("/(1\d{1,4})\d\d\d\d(\d{3,4})/", "\$1****\$2", $tel);
}

function is_weixin(){
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }
 

/**
 * 获取当前URL
 * @author zhuyubiao
 * @date 2016-2-3
 * @return string
 */
function getCurUrl(){
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}


/**
 * 上传图片
 * @param $data string 图片流
 * @author zhaojc
 * @date 2016-2-4
 * @return int/boolean
*/
function uploadPic($data) {
    $imgDir = "upload/".date('Y').'/'.date('m').'/'.date('d').'/'; //新图片名称
    if(!is_dir($imgDir)) {
        mkdir($imgDir, 0777, true);
    }   
    $filename = $imgDir.md5(time().mt_rand(10, 99)).".jpeg";
    $newFile = fopen($filename,"w+");
    $re = fwrite($newFile, base64_decode($_POST['data'])); 
    fclose($newFile);
    return str_replace("upload/", '', $filename); 
}

/**
 * 文件形式上传图片
 * @param $FILE string 文件
 * @author zhancb
 * @date 2016-2-4
 * @return int/boolean
*/
function imgUpload($FILES,$name = 'pic') {
    if(isset($FILES[$name]["tmp_name"]) && !empty($FILES[$name]["tmp_name"])){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;
        $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = C('UPLOAD_DIR');
        $upload->savePath = date('Y').'/'.date('m').'/'.date('d').'/';
        $upload->saveName  = md5(time().mt_rand(10, 99));
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
             return array("code" => 0, "msg" => $upload->getError(),"path" =>'');
        }else{// 上传成功 获取上传文件信息
            return  array("code" => 200, "msg" => "上传成功", "path" => $info[$name]['savepath'].$info[$name]['savename']);     
        }  
    }
}

/**
 * 文件上传
 * @param name 文件名称
 * @author zhaojc
 * @date 2016-2-16
*/
function fileUpload($name) {
    if(empty($_FILES[$name])) {
        return array("status" => 1, "message" => "上传失败");
    }
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize = 3145728;
    $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
    $upload->rootPath = C('UPLOAD_DIR');
    $upload->savePath = date('Ym').'/'.date('Ymd').'/';
    $upload->saveName  = md5(time().mt_rand(10, 99));
    $info   =   $upload->uploadOne($_FILES[$name]);
    if(!$info) {// 上传错误提示错误信息
        return array("status" => 1, "message" => $upload->getError());
    }else{// 上传成功 获取上传文件信息
        //return array("status" => 0, "message" => 'Public/attachment/images/'.$info['savepath'].$info['savename']);
        return array("status" => 0, "message" => $info['savepath'].$info['savename']);          
    }    
}





/**
 * 生成缓存key
 * @param $param array 缓存参数
 *  $param['m'] string 模块
 *  $param['c'] string 控制器
 *  $param['a'] string 方法
 *  $param['arguments'] array 查询参数
 */
function createCacheKey($param) {
    $topKey = C('CACHE_KEY');
    $param['m'] = strtolower($param['m']);
    $param['c'] = strtolower($param['c']);
    $param['a'] = strtolower($param['a']);
    if(empty($param['m']) || empty($param['c']) || empty($param['a'])) {
        return false;
    }
    $cacheKeyParam = '';
    if(!empty($param['arguments'])) {
        foreach($param['arguments'] as $key => $value) {
            $cacheKeyParam .= '_'.$key."_".$value;
        }
    }
    return $topKey.'_'.$param['m'].'_'.$param['c'].'_'.$param['a'].$cacheKeyParam;
}


function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){  
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));

        $len = strlen($str);
        if($len>$length){
          if($suffix) return $slice."…";  
        }
        
        return $slice;
    }


 function printarray($date) {
    echo '<pre>';
    print_r($date);
    die;
}