<?php
namespace Admin\Model;
use Think\Model;
class ManagerModel extends Model
{
	/**
	 * 获取登录信息
	 * @param string $username 登录用户名
	 * @param string $password 登录密码
	 * @return array
	 */
	private $powerObj;

	public function _initialize()
	{
		$this->powerObj = D("manager_powers");
	}

	public function getLoginUser($username, $password)
	{
		$username = trim($username);
		$user = false;
		if (!empty($username) && !empty($password)) {
			$param = array();
			$param['username'] = $username;
			$param['password'] = md5($password);
			$user = $this->where($param)->find();
			//更新登录次数
			if ($user) {
				$this->where(array('uid' => $user['uid']))->setInc('logins', 1);
			}
		}
		return $user;
	}

	//获取用户权限
	public function getUserPower($uid)
	{
		$power = false;
		if ($uid > 0) {
			$power = $this->powerObj->where(array('managerid' => $uid))->getField('power', true);
		}
		return $power;
	}

	//检测用户名是否存在
	public function isExistUser($username)
	{
		$ret = false;
		if (!empty($username)) {
			$where = " username='" . $username . "'";
			$ret = $this->countRecord($where);
		}
		return $ret;
	}

	//保存账号信息
	public function modifyManager($data, $uid)
	{
		if (isset($data['password'])) {
			$data['password'] = md5($data['password']);
		}
		//保存账号信息
		if ($uid > 0) {
			$ismodify = $this->where(array('uid' => $uid))->save($data);
		} else {
			$data['fromuid'] = $_SESSION['u_system']['uid'];
			$ismodify = $this->add($data);
			$uid = $ismodify ? $ismodify : 0;
		}
		//保存账号权限
		if ($uid && !empty($powers)) {
			$this->modifyPowers($powers, $uid);
		}
		return $ismodify;
	}

	/**
	 * 增加用户
	 * @param $username
	 * @param int $ismanager
	 * @return mixed
	 */
	public function addUser($username, $ismanager = 0)
	{
		$username = !empty($username) ? trim($username) : NULL;
		if (!empty($username)) {
			if ($ismanager)
				$data['groupid'] = 868;
			$data['username'] = $username;
			return $this->insert('dp_manager', $data, true);
		}
	}

	/**
	 * 删除用户
	 * @param $uid
	 * @return mixed
	 */
	public function delUser($uid)
	{
		$where['uid'] = $uid;
		return $this->where($where)->delete();
	}

	public function modifyPowers($powers, $uid)
	{
		if ($uid > 0) {
			$list = array();
			$query = $this->query("SELECT power FROM dp_manager_powers WHERE managerid=" . $uid);
			while ($info = $this->fetch($query)) {
				$list[] = $info['power'];
			}

			//删除的权限
			$del_powers = array_diff($list, $powers);
			if (!empty($del_powers)) {
				foreach ($del_powers as $power) {
					$power = trim($power);
					$where = "managerid=" . $uid . " AND power='" . $power . "'";
					$this->delete('dp_manager_powers', $where);
				}
			}

			//新增的权限
			$add_powers = array_diff($powers, $list);
			if (!empty($add_powers)) {
				foreach ($add_powers as $power) {
					$power = trim($power);
					$data = array('managerid' => $uid, 'power' => $power);
					$this->insert('dp_manager_powers', $data);
				}
			}
		}
	}

	/**
	 * 根据id获取账号信息
	 * @param int 管理员id
	 */
	public function getManagerById($id)
	{

		return $this->where(array('uid' => $id))->find();

	}

	/**
	 * 获取记录数量
	 *
	 * @param string $where
	 * @return num
	 */
	public function countRecord($where)
	{
		$SQL = "SELECT COUNT(*) AS num FROM dp_manager WHERE {$where}";
		$info = $this->fetch_first($SQL);
		return $info['num'];
	}

	/**
	 *获取用户信息
	 * @param $self boolean 是否包含自己 false不包含
	 */
	public function getManagerList($self = false)
	{
		if (!$self) {
			$where['groupid'] = array('neq', 868);
		}
		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 20);
		$show = $page->show();
		$record = $this->where($where)->order("lastlogin desc,uid desc")->limit($page->firstRow . ',' . $page->listRows)->select();
		return array($record, $show);
	}

	//根据用户名查询用户信息
	public function getManagerByname($name, $field = '*')
	{
		$name = trim($name);
		$info = $this->fetch_first("SELECT {$field} FROM dp_manager WHERE username='{$name}'");
		return $info;
	}

	//更新登录次数(通用平台)
	public function updateloginnum($uid)
	{
		$uid = intval($uid);
		$this->query("UPDATE dp_manager SET logins=logins+1 WHERE uid=" . $uid);
	}

	public function getCurrentUser()
	{
		if (isset($_SESSION['u_system']))
			return $_SESSION['u_system'];
		else {
			return array("uid" => "13", "username" => "超级管理员", "groupid" => "868");
		}
	}
}