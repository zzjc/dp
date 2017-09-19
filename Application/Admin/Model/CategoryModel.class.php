<?php
namespace Admin\Model;
use Think\Model;
/**
 * 分类管理
 * 
 */	
class CategoryModel extends Model 
{
    

    //验证
    protected $_validate = array(
        array('catename','require','请填写分类名称'),
        array('catename','require','该分类已经存在',0,'unique'),
       // array('catepic','require','请上传分类图片'),
    );


    protected $_auto = array(
        array('displayorder', '99', 1),
        array('dateline', 'time', 1, 'function'),
    );



    /**
     * 拿取分类详情
     * @param $cateid 分类id
     * @return array
     * */
    public function getCateInfo($cateid)
    {
        $where['cateid'] = $cateid;
        return $this->where($where)->find();
    }
	

    /**
     * 拿取分类
     * @return array
     * */
    public function getcatelist()
    {
        $where = array();
        return $this->where($where)->select();
    }
    
    public function getCate()
    {
        $where = array();
        $where['statue'] = 0;
        $cateList = $this->field('cateid,catename')->where($where)->select();
        $result = array();
        foreach($cateList as $key => $val) {
            $result[$val['cateid']] = $val['catename'];
        }
        return $result;
    }   
    //获取cate字段信息
    public function getCateField($field = array(), $where = array()) {
        return $this->field($field)->where($where)->select();
    }
}
?>