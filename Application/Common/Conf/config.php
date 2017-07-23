<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'fristshop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'fanxing',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'fs_',    // 数据库表前缀

    //默认分组的配置参数
    'DEFAULT_MODULE'     =>  'Home',

    //定义我们当前全部的‘分组列表’信息
    'MODULE_ALLOW_LIST'  =>  array('Home','Admin'),

    //给页面底部设置跟踪信息trace
    'SHOW_PAGE_TRACE'    =>  true,
);