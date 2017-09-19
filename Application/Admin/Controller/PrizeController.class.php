<?php
namespace Admin\Controller;
class PrizeController extends BaseController {
    private $backUrl;
    public function _initialize(){
        parent::_initialize(); 
        $this->backUrl = $_SERVER['HTTP_REFERER'];
    }   

    public function index(){
       
        $condition['type'] = 1; 

        $month = I("month",'','intval');
        if($month!=''){
            $condition['month'] = $month; 
        }
        
        $keyword = myAddslashes(I("keyword"));
        if($keyword!=''){
            $condition['title'] = array('like','%'.$keyword.'%');
        }
        
        
        $condition = array_filter($condition); 
    
        $order['sort'] ='asc';
        $order['addtime'] ='desc';
        
        $count = M("prize")->where($condition)->count();
        $Page   = new \Think\Page($count,20);// 
        $show   = $Page->show();
        $list = M("prize")->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
        
        $this->assign('list', $list);
        $this->assign('page',$show);// 
        $this->display();
    }

    public function point(){
       
        $condition['type'] = 2; 

        $month = I("month",'','intval');
        if($month!=''){
            $condition['month'] = $month; 
        }
        
        $keyword = myAddslashes(I("keyword"));
        if($keyword!=''){
            $condition['title'] = array('like','%'.$keyword.'%');
        }
        
        
        $condition = array_filter($condition); 
    
        $order['sort'] ='asc';
        $order['addtime'] ='desc';
        
        $count = M("prize")->where($condition)->count();
        $Page   = new \Think\Page($count,20);// 
        $show   = $Page->show();
        $list = M("prize")->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
        
        $this->assign('list', $list);
        $this->assign('page',$show);// 
        $this->display();
    }

   //添加
    public function add(){

        if(!IS_POST){
            session('backUrl',$this->backUrl);
        }

        $act = I("act"); 
        $type = I("type")?I("type"):1; 
        $act = $act == ''?'add':$act;
        $id = I("id",'',intval);

        if(IS_POST){
            $backUrl = session('backUrl'); 
            session('backUrl',null);  
            $data = $_POST;
                 
            if($act == 'add') {
              $data['addtime'] = time();  
            } 
            
            $M = D('prize');
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
                    ajax_message($msg,$backUrl);    
                }else{
                    output_msg(array('code'=>0,'msg'=>'操作失败'));
                } 
            }    
        }else{ //编辑     
            if($act == 'edit') {    
                $condition['id'] =$id ; 
                $info = M("prize")->where($condition)->find();
                $type = $info['type'];
                $this->assign('info', $info);         
            }
        }
        $this->assign('type',$type);
        $this->assign('act',$act);
        $this->display();
    }

  public function change(){
    $id = I('id','',intval);
    $status = I('status','',intval);
    $data['status'] = $status;
    $condition['id']  =  $id;
    $result =  M("prize")->where($condition)->save($data);
    if($result){
      output_msg(array('code'=>200,'msg'=>'更改成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'更改失败'));
    }
  }

  public function changes(){
      
    $params = I('post.');
    $ids = implode(',', $params['ids']);
    $data['status'] = $status;
    $condition['id']  = array('in',$ids);
    $result =  M("prize")->where($condition)->save($data);
    if($result){
      output_msg(array('code'=>200,'msg'=>'批量更改成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'批量更改失败'));
    }
  }


  public function dels(){
    $id = I('id','','intval');
    if($result = M("prize")->delete( $id)){
      output_msg(array('code'=>200,'msg'=>'删除成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'删除失败'));
    }
  }

  public function delss(){
      
    $params = I('post.');
    $ids = implode(',', $params['ids']);
    $result = M("prize")->delete($ids);
    if($result){
      output_msg(array('code'=>200,'msg'=>'批量删除成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'批量删除失败'));
    }
  }


  /*
  *  批量排序
  */
  public function sorts(){
      
    $params = I('post.');
    $sorts = $params['sorts'];
    foreach($sorts as $key=>$val){
      $condition['id']  = $key;
      $data['sort'] = $val; 
      M("prize")->where($condition)->save($data);
    }
    output_msg(array('code'=>200,'msg'=>'排序成功'));
  }

}