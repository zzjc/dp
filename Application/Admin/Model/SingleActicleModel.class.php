<?php
namespace Admin\Model;
use Think\Model;
class SingleActicleModel extends Model {

	//验证
	protected $_validate = array(
		array('title','require','请填写标题'),
		array('content','require','请填写内容'),
	);



	protected $_auto = array(
        array('status', '1', 1),
        array('addtime', 'time', 1, 'function'),
    );

}