<?php
namespace Home\Controller;
use Common\Controller\BaseController;
class WechatController extends BaseController {   

     /**
     * 根据控制器名，显示信息
     */
    public function setJssdk($title, $desc, $link, $imgUrl){
        $JSSDK =   '\Common\Library\LaneWechat\core\JSSDK'; 
        $signPackage =  $JSSDK::GetSignPackage();
        
        $setData = array('title'=> $title, 'desc'=> $desc,'link'=> $link,'imgUrl'=> $imgUrl);
        $this->assign('signPackage',$signPackage);
        $this->assign('setData',$setData);
    }

    //下载图片
     public function download($mediaId){

        $Media =   '\Common\Library\LaneWechat\core\Media';  
        $filecontent  = $Media::download($mediaId);

        $uploadPath = C('UPLOAD_DIR');
        $imgname = "wechat/".md5(time().mt_rand(10, 99)).'.jpg';
        $filename = $uploadPath.$imgname;

        $fp = fopen($filename, 'w');
        if (false !== $fp){
            if (false !== fwrite($fp, $filecontent)) {
                fclose($fp);
                $result = array('code'=>200,'msg'=>'成功','filename'=>$imgname);
            }else{
                 $result = array('code'=>0,'msg'=>'下载失败');
            }
        }else{
                $result = array('code'=>0,'msg'=>'没有目录权限');
            }
        return $result;     
   }  

}