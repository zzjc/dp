<?php
namespace Admin\Controller;
class RoleController extends BaseController {
    private $backUrl;
    public function _initialize(){
        parent::_initialize(); 
        $this->backUrl = $_SERVER['HTTP_REFERER'];
    }   

    public function index(){
        

        $order['id'] ='desc';
        
        $count = M("role")->where($condition)->count();
        $Page   = new \Think\Page($count,20);// 
        $show   = $Page->show();
        $list = M("role")->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
        $this->assign('list',$list);// 
        $this->assign('page',$show);// 
        $this->display();
    }


   //添加
    public function add(){

        if(!IS_POST){
            session('backUrl',$this->backUrl);
        }

        $act = I("act"); 
        $act = $act == ''?'add':$act;
        $id = I("id",'',intval);

        if(IS_POST){
            $backUrl = session('backUrl'); 
            session('backUrl',null);  
            $data = $_POST;  
            
            $M = D('role');
            if (! $M->create($data)){
                ajax_message($M->getError());
            }else{
                if($act == 'edit') {
                    $result = $M->save();
                    $msg = '编辑成功';
                }else{
                    $result = $M->add();
                    $msg = '添加成功';         
                }      

                if($result){
                    output_msg(array('code'=>200,'msg'=>$msg,'backurl'=>$backUrl));
                }else{
                    output_msg(array('code'=>0,'msg'=>'操作失败'));
                } 
            }    
        }else{ //编辑       
            if($act == 'edit') {    
                $condition['id'] =$id ; 
                $info = M("role")->where($condition)->find();                 
            }
        }
 
        $this->assign('info', $info);
        $this->assign('act',$act);
        $this->display();
    }
   //添加
    public function auth(){
       $id = I("id",'',intval);
        

        if(IS_POST){
            $backUrl = session('backUrl'); 
            session('backUrl',null);  
            $data = $_POST;  
            
            $M = D('role');
            if (! $M->create($data)){
                ajax_message($M->getError());
            }else{
                if($act == 'edit') {
                    $result = $M->save();
                    $msg = '编辑成功';
                }else{
                    $result = $M->add();
                    $msg = '添加成功';         
                }      

                if($result){
                    output_msg(array('code'=>200,'msg'=>$msg,'backurl'=>$backUrl));
                }else{
                    output_msg(array('code'=>0,'msg'=>'操作失败'));
                } 
            }    
        }

        $condition['id'] =$id ; 
        $info = M("role")->where($condition)->find();      
        $this->assign('info', $info);
        $this->assign('act',$act);
        $this->display();
    }


    
   public function changestatus(){
        if (IS_AJAX) {
            $change = I('change');
            $type = I('type');
            $condition['id']  =  $change; 
            $status =M("role")->where($condition)->getField($type);
            if ($status == 1) {
                 $data[$type] = 2;
                 M("role")->where($condition)->save($data);
                 exit('2');
            } else {
                 $data[$type] = 1;
                 M("role")->where($condition)->save($data);
                 exit('1');
            }

        } else {
            $this->error('非法操作');
        }
    }

  

  public function dels(){
    $id = I('id','','intval');
    if($result = M("role")->delete( $id)){
      output_msg(array('code'=>200,'msg'=>'删除成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'删除失败'));
    }
  }

 

}