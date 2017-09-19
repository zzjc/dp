<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台基类
 * 
 * @remark 用于初始化页面基本通用信息
 */
header("Content-type:text/html;charset=utf-8");
class BaseController extends Controller {
	//构造类
	public function _initialize(){
    
        if(!session('username') || !session('userid')){
           $this->error('请登录',U('login/index')); 
        }
		
		$this->_setMenu();
    }
	/*
	* 导航菜单
	* controller:区分大小写
	* action:小写	
	*/
	protected function _setMenu(){
		$menu=array();

		$menu[1]['icon'] = '&#xe63c;';
		$menu[1]['tit'] = '内容管理';

		$menu[1]['sub'][2]=array('tit'=>'每月主题','url'=>U('topic/index'));
		$menu[1]['sub'][1]=array('tit'=>'题目管理','url'=>U('question/index'));
		$menu[1]['sub'][3]=array('tit'=>'抽奖奖品','url'=>U('prize/index'));
		$menu[1]['sub'][4]=array('tit'=>'兑换奖品','url'=>U('prize/point'));
		$menu[1]['sub'][5]=array('tit'=>'领取记录','url'=>U('award/index'));

		$menu[2]['icon'] = '&#xe612;';
		$menu[2]['tit'] = '综合管理';
		$menu[2]['sub'][4]=array('tit'=>'分享配置','url'=>U('config/share'));

		$this->assign('menu',$menu);

	}

}
?>