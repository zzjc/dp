<?php
//共用配置

$setting = array(
    //'配置项'=>'配置值'
    'AVATAR_URL' => 'http://avatar.mama.cn',
    'CDN_URL' => 'http://pics.mama.cn',
    'DEFAULT_MODULE' => 'Home', // 默认模块名称
    'DEFAULT_ACTION' => 'index', // 默认操作名称
    'TOKEN_ON' => true, // 是否开启令牌验证 默认关闭
    'TOKEN_NAME' => '__hash__', // 令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE' => 'md5', //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET' => true, //令牌验证出错后是否重置令牌 默认为true
    'TMPL_ENGINE_TYPE' => 'Discuz',
    'TMPL_LINES_NEW' => true, //去除html空格与换行
    //模板布局
    'LAYOUT_ON' => true,
    'LAYOUT_NAME' => 'layout',
    'URL_MODEL' => 2,
    //缓存key
    'CACHE_KEY' => 'dianping',
    //缓存key生成配置
    'CACHE_CONFIG' => array(
        //首页分类
        'WAP_HOMERECOMMENT_CATELIST' => array(
                'm'     => 'wap',
                'c'     => 'homerecomment',
                'a'     => 'catelist',
                'time'  => 600,
            ),
    ),

    //权限模块白名单
    'MODULES_WHITH_LIST'=>array(
        '1'=>'homerecomment/createcache',
        '2'=>'explosivegoods/createcache',
        '3'=>'activity/createcache',
        '4'=>'hotcity/createcache'
    ),

    
);