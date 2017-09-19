<?php
namespace Admin\Controller;
class AwardController extends BaseController {
    private $backUrl;
    public function _initialize(){
        parent::_initialize(); 
        $this->backUrl = $_SERVER['HTTP_REFERER'];
    }   

    public function index(){
        
        $phone = I("phone",'','intval');
        if($phone!=''){
            $condition['phone'] = $phone; 
        }

        $month = I("month",'','intval');
        if($month!=''){
            $condition['month'] = $month; 
        }
        

        $keyword = myAddslashes(I("keyword"));
        if($keyword!=''){
    			$where['name']  = array('like', '%'.$keyword.'%');
    			$where['nickname']  = array('like','%'.$keyword.'%');
    			$where['_logic'] = 'or';
    			$condition['_complex'] = $where;

        }

        
        $condition = array_filter($condition); 
    
        $order['addtime'] ='desc';
        
        $count = M("award")->where($condition)->count();
        $Page   = new \Think\Page($count,20);// 
        $show   = $Page->show();
        $list = M("award")->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order($order)->select();
        
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
        $act = $act == ''?'add':$act;
        $id = I("id",'',intval);

        if(IS_POST){
            $backUrl = session('backUrl'); 
            session('backUrl',null);  
            $data = $_POST;
            
            $data['addtime'] = time(); 

            $M = D('question');
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
                $info = M("award")->where($condition)->find();         
            }
        }
        $this->assign('info', $info);
        $this->assign('act',$act);
        $this->display();
    }

  public function change(){
    $id = I('id','',intval);
    $status = I('status','',intval);
    $data['status'] = $status;
    $condition['id']  =  $id;
    $result =  M("award")->where($condition)->save($data);
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
    $result =  M("award")->where($condition)->save($data);
    if($result){
      output_msg(array('code'=>200,'msg'=>'批量更改成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'批量更改失败'));
    }
  }


  public function dels(){
    $id = I('id','','intval');
    if($result = M("award")->delete( $id)){
      output_msg(array('code'=>200,'msg'=>'删除成功'));
    }else{
      output_msg(array('code'=>0,'msg'=>'删除失败'));
    }
  }

  public function delss(){
      
    $params = I('post.');
    $ids = implode(',', $params['ids']);
    $result = M("award")->delete($ids);
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
      M("award")->where($condition)->save($data);
    }
    output_msg(array('code'=>200,'msg'=>'排序成功'));
  }



     //导出
    public function export(){
        $phone = I("phone",'','intval');
        if($phone!=''){
            $condition['phone'] = $phone; 
        }

        $month = I("month",'','intval');
        if($month!=''){
            $condition['month'] = $phone; 
        }
        
        $keyword = myAddslashes(I("keyword"));
        if($keyword!=''){
          $where['name']  = array('like', '%'.$keyword.'%');
          $where['prize_name']  = array('like','%'.$keyword.'%');
          $where['_logic'] = 'or';
          $condition['_complex'] = $where;

        }
     
        $condition = array_filter($condition); 
        $order['addtime'] ='desc';
        $list = M("award")->where($condition)->order($order)->select();
        

        $statusArr = array(
            '1' =>"抽奖",
            '2' =>"积分兑换",
        );

        $awardArr = array(
            '1' =>"未",
            '2' =>"是",
        );
 
        $strTable = '<table width="1000" border="1">';
        $strTable .= '<tr>';
        $strTable .= '<td style="text-align:center;width="*">昵称</td>';
        $strTable .= '<td style="text-align:center;" width="*">奖品</td>';
         $strTable .= '<td style="text-align:center;" width="*">获取途径</td>';
        $strTable .= '<td style="text-align:center;" width="*">是否兑换</td>';
        $strTable .= '<td style="text-align:center;" width="*">姓名</td>';
        $strTable .= '<td style="text-align:center;" width="*">电话</td>';
        $strTable .= '<td style="text-align:center;" width="*">月份</td>';
        $strTable .= '<td style="text-align:center;" width="*">时间</td>';

        $strTable .= '</tr>';

        foreach ($list as $k => $v) {
       

            $strTable .= '<tr>';
            $strTable .= '<td style="text-align:center;">&nbsp;' .$v['nickname'] . '</td>';
            $strTable .= '<td style="text-align:left;">' . $v['prize_name'] . ' </td>';
            $strTable .= '<td style="text-align:left;">' . $statusArr[$v['type']] . ' </td>';
            $strTable .= '<td style="text-align:left;">' . $awardArr[$v['is_award']] . ' </td>';
            $strTable .= '<td  style="text-align:left;">' . $v['name'] . ' </td>';
            $strTable .= '<td style="text-align:left;">' . $v['phone'] . ' </td>';
            $strTable .= '<td style="text-align:left;">' . $v['month'] . ' </td>';
            $strTable .= '<td style="text-align:left;">' . date('Y-m-d',$v['addtime']) . ' </td>';
            $strTable .= '</tr>';
            
        }
        $strTable .= '</table>';
        downloadExcel($strTable, '中奖记录_'.date('Ymd'));
        exit();
    }
}