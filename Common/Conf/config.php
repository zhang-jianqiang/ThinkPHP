<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'db_oa',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'tp_',    // 数据库表前缀
    'SHOW_PAGE_TRACE'       =>  true,     //跟踪错误信息
    //RBAC权限控制
    'RBAC_ROLES'            => arraY(
                        1   => '高层领导',
                        2   => '中层领导',
                        3   => '普通职员'     
        ),
    //权限数组
    'RBAC_AUTHS'            => array(
                        '1' => array('doc/*','dept/*','knowledge/*','email/*','user/*'),
                        '2' => array('email/*', 'knowledge/*'),
                        '3' => array('email/*')

        ),
);