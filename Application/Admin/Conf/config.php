<?php
return array(
	//'配置项'=>'配置值'
	'URL_HTML_SUFFIX' => '',
	'URL_MODEL' => 2, 
	'WAP_HOST' => "",
	
	//RBAC配置增加设置  
	'USER_AUTH_MODEL'    =>'Member',  
	'USER_AUTH_ON'   =>true,  //是否需要认证  
	'USER_AUTH_TYPE'     =>'1',   //认证类型:1为登录模式，2为实时模式  
	'USER_AUTH_KEY'  =>'userid',    //认证识别号（SEESION的用户ID名）  
	'ADMIN_AUTH_KEY'     =>'admin',  //管理员SEESION  
	'REQUIRE_AUTH_MODULE'   =>'',     //需要认证模块（模块名之间用短号分开）  
	'NOT_AUTH_MODULE'    =>'Login,Base',    //无需认证模块（模块名之间用短号分开）  
	'REQUIRE_AUTH_ACTION'   =>'',     //需要认证方法（方法名之间用短号分开）  
	'NOT_AUTH_ACTION'    =>'',    //无需认证方法（方法名之间用短号分开）  
	'USER_AUTH_GATEWAY'  =>'/Login/index',    //认证网关  
	'RBAC_USER_TABLE'    =>'bbs_role_user',    //用户角色明细表  
	'RBAC_ROLE_TABLE'    =>'bbs_role',  //角色表  
	'RBAC_ACCESS_TABLE'  =>'bbs_access',    //权限表  
	'RBAC_NODE_TABLE'    =>'bbs_node',  //节点表 
);