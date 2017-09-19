<?php
namespace Admin\Controller;
class IndexController extends BaseController{
   
	public function index() {
         $this->display();
    }
	
	public function home(){
         $this->display();
    }

	function update(){
		
		array_map('unlink', glob(TEMP_PATH . '/*.php'));
        rmdir(TEMP_PATH);
		output_msg(array('code'=>200,'msg'=>'更新缓存成功'));
	}
}