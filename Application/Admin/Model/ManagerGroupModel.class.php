<?php
namespace Admin\Model;
use Think\Model;
class ManagerGroupModel extends Model
{

	protected $tableName = 'manager_group';
	protected $_validate = array(
		array('name', 'require', '分组名称不能为空'),
		array('modules', 'require', '请选择分组列表')
	);

	//获取管理分组列表
	public function getGroupList()
	{
		return $this->field('id,name,modules')->order("id desc")->select();
	}
	
	/**
	 * 根据分组id获取分组信息
	 *
	 * @param int $groupId
	 * @return array
	 */
	public function getGroupById($groupId)
	{
		$where['id'] = $groupId;
		$data = $this->field('id,name,modules')->where($where)->select();
		if (empty($data)) {
			return array();
		}
		return $data[0];
	}
	
	/**
	 * 根据分组id获取分组信息
	 *
	 * @param array $data
	 * @return bool
	 */
	public function saveGroup($data)
	{
		$groupId = empty($data['groupId']) ? NULL : $data['groupId'];
		$setdata = $this->create($data);

		if (!$setdata) {
			return $this->getError();
		}

		if (is_null($groupId)) {
			if (!$this->add($setdata))
				return false;
		} else {
			$where['id'] = $groupId;
			if (!$this->where($where)->save($setdata))
				return false;
		}
		return true;
	}

	public function deleteGroup($groupId)
	{
		$where['id'] = $groupId;
		return $this->where($where)->delete();
	}
}