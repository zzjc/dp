<?php
namespace Home\Controller;
use Common\Controller\BaseController;
class IndexController extends BaseController {
    private $startData;
    private $nowData;

    public function _initialize(){
        parent::_initialize();
        //微信分享
        if(IS_WEIXIN){
            $Wechat = A('Wechat');
            $link = APP_URL.U('Index/index');

            $infocacheKey = 'CACHE_KEY_SHARE';
            $shareSetting = S($infocacheKey);
			$shareSetting = '';
            if (empty($shareSetting)) {
				
                $config = M("config")->find();
                $shareSetting = $config['share'];
                S($infocacheKey, $shareSetting , 7200);
            }

            $shareInfo = json_decode($shareSetting,true);
            $title = $shareInfo['title']?$shareInfo['title']:'';
            $desc =  $shareInfo['desc']?$shareInfo['desc']:'';
            $imgUrl = $shareInfo['pic']?C('IMG_CDN_URL').$shareInfo['pic']:C('STATIC_URL')."Public/home/images/share.jpg";
            $link = APP_URL.U('Index/index');
            $Wechat ->setJssdk($title, $desc, $link, $imgUrl);
        }
        $this->assign('title','美丽坪山');

    }
    public function index(){
         $this->assign('month', date('n')); 
         $this->display();
    }

    public function rule(){
        $list = $this->prizeList(2);
        $this->assign('month', date('n')); 
        $point = M("Member")->where(array('openid'=>$this->openid))->getField('point');
        $this->assign('point', $point);
        $this->assign('list', $list);  
        $this->display();
    }

    public function start(){
        $month = I("month",'','intval');
        $map['month'] = $month;
        $map['openid'] = $this->openid;
   
        $answerList = M("answer_record")->where($map)->getField('question_id,is_right');
        $num = count($answerList);
        if($num>=10){
            $this->success($month);
        }

        $condition['month'] = $month;
        $topic = M("topic")->where($condition)->find();
        $this->assign('topic', $topic); 
        $this->display();
    }


    public function ajaxquestion(){
        $month = I("month",'','intval');
        if($month!=''){

            if(date('Y-n')<date('Y').'-'.$month){
               output_msg(array('code'=>10,'msg'=>'该试题库未形成'));
            }
            
            $order['sort'] ='asc';
            $order['addtime'] ='desc';
            $condition['month'] = $month;
            $info = M("question")->where($condition)->find();
            if(!$info){
                output_msg(array('code'=>20,'msg'=>'该试题库未形成'));
            }else{
                output_msg(array('code'=>200,'msg'=>'成功','backurl'=>U('index/question',array('month'=>$month))));
            }
        }   
    }

    public function question(){
        $month = I("month",'','intval');
        if($month!=''){

            if(date('Y-n')<date('Y').'-'.$month){
               ajax_message('该试题库未形成'); 
            }
            
            $order['sort'] ='asc';
            $order['addtime'] ='desc';
            $condition['month'] = $month;
            $questionList = M("question")->where($condition)->getField('id,month,title,section1,section2,section3,section4,pic,explain_title,explain_link');
            if(!$questionList){
                ajax_message('该试题库未形成'); 
            }
            
            $map['month'] = $month;
            $map['openid'] = $this->openid;
            $answerList = M("answer_record")->where($map)->getField('question_id,is_right');
            $num = count($answerList);
            if($num>=10){
                $this->success($month);
            }

            if($answerList){
                $questionList = array_diff_key($questionList , $answerList);
            }
    
            $info =  reset($questionList);
            $this->assign('num', $num+1);
            $this->assign('info', $info);

        }else{
            ajax_message('请选择正常月份');
        }   

         $this->display();
    }




    public function answer(){
 
        $question_id = I("question_id",'','intval');
        $condition['question_id'] = $question_id;
        $condition['openid'] = $this->openid;
        $answerInfo = M("answer_record")->where($condition)->find();

        $map['id'] = $question_id;
        $questionInfo = M("question")->where($map)->find();

        if($answerInfo){
            $answerInfo['msg'] = "很可惜答错了!"; 
            if( $answerInfo['is_right']==1){
                $answerInfo['msg'] = "恭喜你答对了!";   
            }
             $answerInfo['knowledge'] = $questionInfo['knowledge'];
             $answerInfo['right_answer'] = $questionInfo['answer'];  
            $this->assign('answerInfo', $answerInfo); 
        }else{
            if(IS_POST){
                $answer = I('answer','','intval');
                
                $data['question_id']    =$question_id ;
                $data['openid']    = $this->openid;
                $data['nickname']  =$this->nickname;
                $data['month']    = $questionInfo['month'];
                $data['answer']   =$answer; 
                $data['is_right'] =$questionInfo['answer']==$answer?1:2;   
                $data['addtime']     =time();

                $res= M('answer_record')->add($data);
                if(!$res){
                    output_msg(array('code'=>20,'msg'=>'网络出错'));
                }else{
                    if($data['is_right']==1){
                        $memberMap['openid'] = $this->openid;
                        M('member')->where($memberMap)->setInc('point');
                    }
                    output_msg(array('code'=>200,'msg'=>'成功','backurl'=>U('index/answer',array('question_id'=>$question_id))));
                }
            }else{
               $this->redirect(U('index/index'));
            }          
        }

        $recordMap['month'] = $answerInfo['month'];
        $recordMap['openid'] = $this->openid;
        $answerCount = M("answer_record")->where($recordMap)->count();
        if($answerCount>=10){
            $recordMap['is_right'] = 1;
            $rightCount = M("answer_record")->where($recordMap)->count();
            $point = M("Member")->where(array('openid'=>$this->openid))->getField('point');
            $this->assign('rightCount', $rightCount); 
            $this->assign('point', $point); 
        }

        $answerArr = array(1=>'A',2=>'B',3=>'C',4=>'D');
        $this->assign('answerArr', $answerArr); 
        $this->display();
    }


    public function success($month){
        $recordMap['month'] = $month;
        $recordMap['openid'] = $this->openid;
        $recordMap['is_right'] = 1;
        $rightCount = M("answer_record")->where($recordMap)->count();
        $point = M("Member")->where(array('openid'=>$this->openid))->getField('point');
        $this->assign('rightCount', $rightCount); 
        $this->assign('point', $point);         
        $this->display('success');
        die;
    }

     public function fail($msg){
        $msg =  $msg?$msg:'抱歉，网络错误。';
        ajax_message($msg);
        exit();
    }

     
    //抽奖页面
    public function lottery() {
        //转盘对应位置
        //25 65 110 155 205 250 290 335
        $prizeArr = array(
            0 =>"height: 4.4rem; top: 5rem; right: 9.5rem;transform:rotate(25deg);-o-transform:rotate(25deg);-webkit-transform:rotate(25deg);",
            1 =>"height: 4.4rem; top: 9rem; right: 4.5rem;transform:rotate(65deg);-o-transform:rotate(65deg);-webkit-transform:rotate(65deg);",
            2=>"height: 4.4rem; bottom: 9rem; right: 4.5rem;transform:rotate(110deg);-o-transform:rotate(110deg);-webkit-transform:rotate(110deg);",
            3 =>"height: 4.4rem; bottom: 5rem; right: 9rem; transform:rotate(155deg);-o-transform:rotate(155deg);-webkit-transform:rotate(155deg);",
            4 =>"height: 4.4rem; bottom: 5rem; left: 9rem; transform:rotate(205deg);-o-transform:rotate(205deg);-webkit-transform:rotate(205deg);",
            5 =>"height: 4.4rem; bottom: 9rem; left: 4.5rem; transform:rotate(250deg);-o-transform:rotate(250deg);-webkit-transform:rotate(250deg);",
            6 =>"height: 4.4rem; top: 9.5rem; left: 4.5rem; transform:rotate(290deg);-o-transform:rotate(290deg);-webkit-transform:rotate(290deg);",
            7 =>"height: 4.4rem; top: 5rem; left: 9rem; transform:rotate(335deg);-o-transform:rotate(335deg);-webkit-transform:rotate(335deg);"
        );


        $list = $this->prizeList(1,8);
        $point = M("Member")->where(array('openid'=>$this->openid))->getField('point');
        $this->assign('point', $point);

        if(!$list){
            $this->error('该活动已经结束');
        }

        $this->assign('prizeArr', $prizeArr);
        $this->assign('list', $list); 
        $this->display();
    }


    //奖品详情
    public function getPrize() {
        $this->display();
    }

    //抽奖
    public function ajaxLottery(){
        if(IS_AJAX){
            
            $memberInfo = M('member')->where(array('openid'=>$this->openid))->find();
             //分享抽奖
            if($memberInfo['is_share']==1){
                $type=2;
            }else{
                $type=1;
                if($memberInfo['point']<3){
                    output_msg(array('code'=>0,'msg'=>'你的环保星星不足'));  
                } 

                $condition['openid'] =  $this->openid;   
                $condition['type'] =  1;
                $starTime = strtotime(date('Y-m-d 00:00:00'));
                $endTime = strtotime(date('Y-m-d 23:59:59'));
                $condition['addtime'] = array(between,array($starTime,$endTime));
                $lotterynum= M('lottery_record')->where($condition)->count();

                if($lotterynum>=1){  //
                    output_msg(array('code'=>0,'msg'=>'很遗憾，今天抽奖机会已用完')); 
                }
            }

            
            //获取抽奖信息
            $list = $this->prizeList(1,8);
            //printarray($list);

            if(!$list){
                output_msg(array('code'=>110,'msg'=>'抽奖人数较多，请稍后再试!'));
            }

            $prize_arr = array(); //比例数组
            //抽奖机会

            foreach( $list as $key=>$val){
                //检查库存
                $map['prize_id'] = $val['id'] ;
                $map['type'] = 1;
                $map['month'] = date('n');
                $count = M("award")->where($map)->count();
                if($count>=$val['store']){
                     $prize_arr[$key] = 0;
                }else{
                    $prize_arr[$key] = $val['rate'];   
                }
                
            }


            

            //抽中id
            $prize_key = $this->get_rand($prize_arr);
  
            //插入记录
            $data['openid'] = $this->openid ;
            $data['prize_id'] = $list[$prize_key]['id'] ;
            $data['prize_title'] = $list[$prize_key]['title'] ;
            $data['type'] = $type ;
            $data['addtime'] = time();
            $res =  M('lottery_record')->add($data);

             //25 65 110 155 205 250 290 335
            $degArr = array(0 =>25,1 =>65,2 =>110,3 =>155,4 =>205,5 =>250,6 =>290,7 =>335);
            //中奖
            if($list[$prize_key]['is_winning']==1){
                 //减少次数
                $data =array();    
                $data['prize_name']  =$list[$prize_key]['title'];
                $data['type']    = 1;
                $data['prize_id'] =$list[$prize_key]['id'];
                $data['openid']   =$this->openid;
                $data['nickname'] =$this->nickname;
                $data['addtime']  =time();
                $data['month']  =date('n');
                $awardid =M('award')->add($data);
                $backurl = U('index/award',array('id'=>$awardid));
                //减少积分
                
               
            }else{
                $backurl = U('index/lottery');
            }

            if($type==2){
               $point = $memberInfo['point']; 
               M('member')->where(array('openid'=>$this->openid))->save(array('is_share'=>2)); 
            }else{
               $point = $memberInfo['point']-3; 
               M('member')->where(array('openid'=>$this->openid))->setDec('point',3);     
            }

            output_msg(array('code'=>200,'msg'=>'success','point'=>$point,'backurl'=>$backurl,'prizeid'=>$prize_key ,'deg'=>$degArr[$prize_key],'prizename'=>$list[$prize_key]['title'],'is_winning'=>$list[$prize_key]['is_winning']));

            

        }
    }

  
    //获取抽奖的奖品

    public function prizeList($type,$limit=4) {

        $condition['type'] =  $type;
        $order['sort'] ='asc';
        $order['addtime'] ='desc';
        
        $info= M('prize')->where($condition)->limit($limit)->order($order)->select();
    

        return $info;
    }




    //抽奖
    //$prize_arr = array('1'=>1;'2'=>99)
    public function get_rand($prize_arr) {
        $result = '';
        //概率数组的总概率精度
        $priSum = array_sum($prize_arr);
        //概率数组循环
        foreach ($prize_arr as $key => $priCur) {
            $randNum = mt_rand(1, $priSum);
            if ($randNum <= $priCur) {
                $result = $key;
                break;
            } else {
                $priSum -= $priCur;
            }
        }
        unset ($prize_arr);
        return $result;
    }
    
     public function award(){
        $id = I('id','','intval');
        $map['id'] = $id;
        $map['openid'] = $this->openid;
        $info = M('award')->where($map)->find();
        $this->assign('info', $info); 

        $this->display();
     }


    public function ajaxAward(){

        if(!IS_POST){
           output_msg(array('code'=>0,'msg'=>'请求方式有误'));
        }

        if(!$this->openid){
            output_msg(array('code'=>0,'msg'=>'请在微信上打开该页面'));
        }

        $id = I('id','','intval');
        $map['id'] = $id;
        $map['openid'] = $this->openid;
        $info = M('award')->where($map)->find();

        if(!$info){
             output_msg(array('code' => 0, 'msg' => '信息错误！'));
        }

        if ($info['is_award']==2) {
            output_msg(array('code' => 0, 'msg' => '你已经领取了'));
        }
        
        $name = I('name');
        $phone = I('phone');

        if(empty($id) || empty($name)||  empty($phone) ){
            $result['code'] = 4020;
            $result['msg'] = '请填写完整的资料';
            output_msg($result);
        }

   
        $data['is_award']    =2;
        $data['name']    = $name;
        $data['phone']    =$phone;
        $res =M('award')->where($map)->save($data);
        
        if($res){
            $result['code']=200;
            $result['msg']="领取成功";
            output_msg($result);  
        }else{
            $result['code']=101;
            $result['msg']="网络繁忙，请稍后再试";
            output_msg($result);   
        }                

    }
     
    //兑换
    public function exchange() {
        $list = $this->prizeList(2);
        $point = M("Member")->where(array('openid'=>$this->openid))->getField('point');
        $this->assign('point', $point);
        $this->assign('list', $list);
        $this->display();
    }

    //兑换
    public function ajaxExchange(){

        if(!IS_POST){
           output_msg(array('code'=>0,'msg'=>'请求方式有误'));
        }

        if(!$this->openid){
            output_msg(array('code'=>0,'msg'=>'请在微信上打开该页面'));
        }

        $prize_id = I('prize_id','','intval');
        $map['id'] = $prize_id ;
        $map['type'] = 2;
        $info = M('prize')->where($map)->find();
 
        if (!$info) {
            output_msg(array('code' => 0, 'msg' => '该奖品不存在'));
        }

        $amap['prize_id'] = $prize_id ;
        $amap['type'] = 2;
        $count = M("award")->where($amap)->count();
        if($count>=$info['store']){
            output_msg(array('code' => 0, 'msg' => '该奖品已经兑换完'));
        }

        
        $point = M("Member")->where(array('openid'=>$this->openid))->getField('point');
        if($point<$info['rate']){
            output_msg(array('code' => 0, 'msg' => '环保星星不足'));
        }

        $res = M("Member")->where(array('openid'=>$this->openid))->setDec('point',$info['rate']);
        if($res){
            $data['prize_name']  =$info['title'];
            $data['type']    = 2;
            $data['prize_id'] =$prize_id ;
            $data['openid']   =$this->openid;
            $data['nickname'] =$this->nickname;
            $data['addtime']  =time();
            $data['month']  =date('n');
            $id =M('award')->add($data);
            
            if($id){
                $result['point']= $point-$info['rate']; 
                $result['code']=200;
                $result['msg']="兑换成功";
                $result['backurl']=U('index/award',array('id'=>$id));
                output_msg($result);  
            }

        }else{
            $result['code']=101;
            $result['msg']="网络繁忙，请稍后再试";
            output_msg($result);   
        }                

    }
   

    //分享
    public function ajaxShare(){

       // if(IS_AJAX){
            if($this->openid==''){
                output_msg(array('code'=>0,'msg'=>'error'));
            }   
            $condition = array('openid'=>$this->openid);

            $is_share = M('member')->where($condition)->getField('is_share'); 
            if($is_share==0){
                $data['is_share'] =1 ;
                $res =  M('member')->where($condition)->save($data);    
            }   
            
            output_msg(array('code'=>200,'msg'=>'成功'));
        //}else{
         //   output_msg(array('code'=>0,'msg'=>'系统出错，请稍后再试'));
       // }

    
    }
	
	public function monthshow(){
        // $this->assign('month', date('n')); 
         $month = date('n');
		 //$month = 1;		 
         $style = array(
            1 =>array("height:9rem; top:13rem; left:12rem;","width:25rem; top: -3rem; left: 17.2rem;"),
            2 =>array("height:8.75rem; top:12rem;left:.5rem;","width: 25rem; top: 15rem; left: -2.8rem;"),
            3 =>array("height:8.55rem; top:27rem; left:16rem;","width: 35rem;top: 21rem;left: 11rem;"),
            4 =>array("height:8.7rem; top:27rem; left:7.6rem;","width: 36.8rem;top: 23rem;left: -8.7rem;"),
            5 =>array("height:7.5rem; top:28rem; left:21rem;","width: 36.8rem;top: 21rem;left: 1.3rem;"),
            6 =>array("height:8.5rem; top:27rem; left:14rem;","width: 38rem;top: 23rem;left: -8rem;"),
            7 =>array("height:8.4rem; top:20rem; left:14rem;","width: 38rem;top: 12rem;left: 8.2rem;"),
            8 =>array("height:8.4rem; top:25rem; left:10rem","width:28rem;top:23rem; left:-4.2rem;"),
            9 =>array("height:8.6rem; top:27rem; right:5rem;","width:30rem; top:26rem; right:0rem;"),
            10 =>array("height:9.55rem; top:26rem; left:10rem;","width:30rem; top:19rem; left:-6rem;"),
            11 =>array("height:8.85rem; top:26rem; left:17.5rem;","width:32rem; top:20rem; left:13.3rem;"),
            12 =>array("height:10rem; top:36rem; left:1.9rem;","width:37.2rem; top:30rem; left:0.5rem;"),
        );
         $this->assign('month', $month );
         $this->assign('startUrl', U("index/start",array('month'=>$month)));  
         $this->assign('style', $style[$month]);
         $this->display();
    }

}