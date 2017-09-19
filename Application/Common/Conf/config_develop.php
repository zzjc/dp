<?php
//获取公共setting配置
require dirname(__FILE__) . '/setting.php';

return $config = array(
    //'STATIC_URL' => 'http://cdn.chemiss.net/', 
    // 'IMG_CDN_URL'=>'http://cdn.chemiss.net/upload/', 
    'STATIC_URL' => APP_URL.'/', 
    'IMG_CDN_URL'=>APP_URL, 
    'UPLOAD_DIR' => './upload/',

    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => 'localhost', // 服务器地址
    'DB_NAME' => 'jiedaoban', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'root', // 密码'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'bbs_', // 数据库表前缀
    'DB_CHARSET' => 'utf8', // 字符集
    'FRONT_VER'=>201704103211111,
    //'DATA_CACHE_TYPE'=>'Redis', 

    //微信配置
    'WX_APPID' => 'wxd0d5f5ce72058d18',
    'WX_SECRET'=> 'b3bd8dc9b82b99911755b0efcf84ffef',
    
   

);

//合并数组
//return array_merge($config, $setting);