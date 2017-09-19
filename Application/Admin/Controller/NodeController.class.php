<?php
namespace Admin\Controller;
class NodeController extends BaseController {
    private $backUrl;
    public function _initialize(){
        parent::_initialize(); 
        $this->backUrl = $_SERVER['HTTP_REFERER'];
       
        //printarray($node_list);
    }   

    public function index(){
        $node_list = M('node')->order(array('sort'=>'asc','id'=>'asc'))->select();
        $node_list = array2level($node_list);
        $this->assign('node_list', $node_list);
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
        $pid = I("pid",0,intval);
        if(IS_POST){
            $backUrl = session('backUrl'); 
            session('backUrl',null);  
            $data = $_POST;  
            if($pid>0){
              $level = M('node')->where(array('id'=>$pid))->getField('level');
              $data['level'] = $level+1;
            }else{
              $data['level'] = 1;
            }

            $M = D('node');
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
                $info = M("node")->where($condition)->find();
                $pid = $info['pid'];                
            }

             $map['level'] = array('ELT',2);
             $node_list = M('node')->where($map)->order(array('sort'=>'asc','id'=>'asc'))->select();
             $node_list = array2level($node_list);
             $this->assign('node_list', $node_list);
        }
        
        $this->assign('pid', $pid);
        $this->assign('info', $info);
        $this->assign('act',$act);
        $this->display();
    }


    public function getJson(){

        $id = I("id",'',intval);
        $condition['role_id'] =$id ; 
        $node_ids =M('access')->where($condition)->getField('node_id',true);
        $node_list  = M('node')->field('id,pid,title')->select();
        foreach ($node_list as $key => $value) {
            in_array($value['id'], $node_ids) && $node_list[$key]['checked'] = true;
        }

        echo  json_encode($node_list);die; 
    }


     /**
     * 更新权限组规则
     * @param $id
     * @param $auth_rule_ids
     */
    public function setAcess(){
        $id = I("id",'',intval);
        $auth_node_ids = I("auth_node_ids",'');
         if($id=='' || $auth_node_ids=='' ){
          output_msg(array('code'=>0,'msg'=>'参数错误'));
        }
        $condition['role_id'] =$id ; 
        $info = M('access')->where($condition)->find();
        if($info){     
            $res=M('access')->where($condition)->delete();
            if(!$res){
              output_msg(array('code'=>0,'msg'=>'授权失败'));
            }
        }

        foreach($auth_node_ids as $key=>$val){
          $dataList[] = array('role_id'=>$id,'node_id'=>$val);
        } 

        $rs = M('access')->addAll($dataList);
        if($rs){
           $backUrl = U('role/index');
           output_msg(array('code'=>200,'msg'=>'授权成功','backurl'=>$backUrl));
        }
        
    }

   public function changestatus(){
        if (IS_AJAX) {
            $change = I('change');
            $type = I('type');
            $condition['id']  =  $change; 
            $status =M("node")->where($condition)->getField($type);
            if ($status == 1) {
                 $data[$type] = 2;
                 M("node")->where($condition)->save($data);
                 exit('2');
            } else {
                 $data[$type] = 1;
                 M("node")->where($condition)->save($data);
                 exit('1');
            }

        } else {
            $this->error('非法操作');
        }
    }

  

  public function change(){
    $id = I('id','',intval);
    $status = I('status','',intval);
    $data['status'] = $status;
    $condition['id']  =  $id;
    $result =  M("node")->where($condition)->save($data);
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
    $result =  M("node")->where($condition)->save($data);
    if($result){
      output_msg(array('code'=>200,'msg'=>'批量更改成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'批量更改失败'));
    }
  }


  public function dels(){
    $id = I('id','','intval');
    if($result = M("node")->delete( $id)){
      output_msg(array('code'=>200,'msg'=>'删除成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'删除失败'));
    }
  }

  public function delss(){
      
    $params = I('post.');
    $ids = implode(',', $params['ids']);
    $result = M("node")->delete($ids);
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
      M("node")->where($condition)->save($data);
    }
    output_msg(array('code'=>200,'msg'=>'排序成功'));
  }

}