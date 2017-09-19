<?php
namespace Admin\Model;
use Think\Model;
class ManagerModuleModel extends Model {
	protected $tableName = 'manager_module';
	protected $_validate = array(
		array('name','require','分组名称不能为空'),
		array('controller','require','请选择控制器标示'),
		array('url','require','请选择跳转链接')
	);

	/**
	 * 根据分组id获取分组信息
	 * 
	 * @param int $groupId
	 * @return array
	 */

	public function getModuleById($moduleId){
		$where['id'] = $moduleId;
		$data = $this->where($where)->select();
		if(empty($data))
		{
			return array();
		}

		return $data[0];
	}

	public function getModuleByIds($moduleIds){
		$where['id'] = array('IN',$moduleIds);
		$data = $this->field('id,name,controller,url')->where($where)->select();
		if(empty($data))
		{
			return array();
		}

		return $data;
	}

	/**
	 * 根据分组id获取分组信息
	 * 
	 * @param array $data
	 * @return bool 
	 */
	public function saveModule($data){
		$moduleId = empty($data['moduleId'])?NULL:$data['moduleId'];
		if(count($data['name']) == 0) {
			return '分组名称不能为空';
		}
		$level = 1;
		//pid不等于0
		if($data['pid']) {
			if(count($data['controller']) == 0) {
				return '请选择控制器标示';
			}
			if(count($data['url']) == 0) {
				return '请选择跳转链接';
			}
			$level = $this->where(array('id' => $data['pid']))->getField('level');
			$level++;
		} 
		$data['level'] = $level;
		if(is_null($moduleId)){
			if(!$this->add($data))
				return false;			
		}else{
			$where['id'] = $moduleId;
		    if(!$this->where($where)->save($data))
		    	return false;

		}
		return true;
	}

	public function deleteModule($moduleId){
		$where['id'] = $moduleId;
		return  $this->where($where)->delete();
	}
}