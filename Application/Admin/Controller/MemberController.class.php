<?php
namespace Admin\Controller;
class MemberController extends BaseController{

    public function index(){


         //分类列表
        $ks = I('ks');
        if($ks){
             $condition['username'] = array('like',$ks);   
        }
       
        $condition = array_filter($condition); 
        $order['userid'] ='desc';
        

        $count = M('member')->where($condition)->count();
        $Page   = new \Think\Page($count,20); 
        $show   = $Page->show();
        $list = M("member")->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();

        $this->assign('list', $list);
        $this->assign('page',$show);// 
        $this->display();
        

    }

    public function add()
    {

        if(IS_POST){
            $data = I('post.');
            $data['regtime']=time();
            $data['password']=substr(md5(I('password')),8,16);
            $data['grades']=0;
            $data['userhead'] = '/uploads/20170401/default.png';
            $data['userip']=$_SERVER['REMOTE_ADDR'];
            if(M('member')->add($data)){
                output_msg(array('code'=>200,'msg'=>'添加成功'));
            }else{
                output_msg(array('code'=>0,'msg'=>'添加失败'));
            }
        }
        $tptc=M('member')->select();
        $this->assign('tptc',$tptc);
        $this->display();
    }

    public function edit()
    {

        if(IS_POST){
            $data=I('post.');
            if(M('member')->edit($data)){
                output_msg(array('code'=>200,'msg'=>'修改成功'));
            }else{
                output_msg(array('code'=>0,'msg'=>'修改失败'));
            }
        }
        $tptc=M('member')->find(I('id'));
        $this->assign('tptc',$tptc);
        $this->display();
    }

    public function edits()
    {

        if(IS_POST){
            $data=I('post.');
            $data['password']=substr(md5(I('password')),8,16);
            if(M('member')->edit($data)){
                output_msg(array('code'=>200,'msg'=>'修改成功'));
            }else{
                output_msg(array('code'=>0,'msg'=>'修改失败'));
            }
        }
        $tptc=M('member')->find(I('id'));
        $this->assign('tptc',$tptc);
        $this->display();
    }

    public function dels(){

        if(M('member')->destroy(I('post.id'))){
            output_msg(array('code'=>200,'msg'=>'删除成功'));
        }else{
            output_msg(array('code'=>0,'msg'=>'删除失败'));
        }
    }

    public function delss(){

        $params = I('post.');
        $ids = implode(',', $params['ids']);
        $result = M('member')->batches('delete',$ids);
        if($result){
            output_msg(array('code'=>200,'msg'=>'批量删除成功'));
        }else{
            output_msg(array('code'=>0,'msg'=>'批量删除失败'));
        }
    }

    public function changestatus(){
        if(IS_AJAX){
            $change=I('change');
            $status=db('member')->field('status')->where('userid',$change)->find();
            $status=$status['status'];
            if($status==1){
                M('member')->where('userid',$change)->update(['status'=>0]);
                echo 1;
            }else{
                M('member')->where('userid',$change)->update(['status'=>1]);
                echo 2;
            }
        }else{
            $this->error('非法操作');
        }
    }

}
