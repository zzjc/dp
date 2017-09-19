<?php
namespace Admin\Model;
use Think\Model;
class ProductModel extends Model {
//验证
  protected $_validate = array(
    array('title','require','请输入标题'),

  );



  protected $_auto = array(
        array('displayorder', '0', 1),
        array('status', '1', 1),
        array('addtime', 'time', 1, 'function'),
    );
}