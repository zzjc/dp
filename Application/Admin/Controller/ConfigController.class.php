<?php
namespace Admin\Controller;
class ConfigController extends BaseController{

       public function share(){
        

        if(IS_POST){

            $data['title'] = I('title');
            $data['desc'] =   I('desc');
            $data['pic'] =  I('pic');
            $share = json_encode($data);
            $res= M("config")->where('1=1')->save(array('share'=>$share));
            if($res){
                output_msg(array('code'=>200,'msg'=>'操作成功'));
            }else{
                output_msg(array('code'=>0,'msg'=>'操作失败'));
            }
             
        }

        $info = M("config")->find();
        if($info['share']){
            $shareInfo = json_decode($info['share'],true);
            $this->assign('shareInfo',$shareInfo);
        }   
        $this->display();
    }

}
