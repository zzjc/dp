<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{

    public function index()
    {	

        if (IS_POST) {
            $code = I('code');
            $res = $this->checkVerify($code);
            if(!$res){
            	output_msg(array('code' => 0, 'msg' => '验证码错误'));
            }
            $data = I('post.');
            $user = M('member')->where(array('grade' => 1,'username'=> $data['username']))->find();
            if ($user) {
                if ($user['password'] == substr(md5($data['password']), 8, 16)) {  
                    session('usermail', $user['usermail']);
                    session('username', $user['username']);
                    session('userid', $user['userid']);
                    session('userhead', $user['userhead']);
                    output_msg(array('code' => 200, 'msg' => '登录成功'));
                    
                } else {
                    output_msg(array('code' => 0, 'msg' => '密码错误'));
                }
            } else {

                output_msg(array('code' => 0, 'msg' => '账号错误'));
            }
        }
       $this->display();
    }
	
	public function wxlogin(){	

       $this->display();
    }

    //创建验证码
	public function createVerify(){
		$Verify = new \Think\Verify();
		$Verify->fontSize = 25;
		$Verify->length = 4;
		return $Verify->entry();
	}



	//验证码
	public function checkVerify($code, $id = ''){    
		$verify = new \Think\Verify();    
		return $verify->check($code, $id);
	}


    public function logout(){
        session("userid", NULL);
        session("username", NULL);
		session("usermail", NULL);
        output_msg(array('code' => 200, 'msg' => '退出成功'));
    }
}