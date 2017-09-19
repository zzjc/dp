<?php
namespace Admin\Controller;
class ActionController extends BaseController {  
    //添加
    public function upload(){

        $opt = I('opt','upload');
        $obj = I('obj','file');
        if($opt == 'upload'){
            //上传图片
            $result = imgUpload($_FILES,$obj);
            echo json_encode($result);
            exit();

            return;
        }
        
    }   
}