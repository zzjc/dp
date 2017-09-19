<?php
namespace Admin\Model;
use Think\Model;
class BannerModel extends Model {

	//验证
	protected $_validate = array(
		array('picurl','require','请上传banner图片'),

	);



	protected $_auto = array(
        array('displayorder', '0', 1),
        array('status', '1', 1),
        array('addtime', 'time', 1, 'function'),
    );

}