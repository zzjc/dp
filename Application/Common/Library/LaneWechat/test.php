<?php
/**
 * 处理请求
 * Created by Lane.
 * User: lane
 * Date: 13-12-19
 * Time: 下午11:04
 * Mail: lixuan868686@163.com
 * Website: http://www.lanecn.com
 */
require_once($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.'config.php');
class test{
	public static $db=new CONFIG;
	public function t2()
	{
		self::dd();
	}
	public static function dd()
	{
		$has=self::$db->_getField("shop_table","openid","id",1);
		var_dump($has);
		
	}	
}
$ff=new test;
$ff->t2();