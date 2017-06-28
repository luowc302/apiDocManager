<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 主要关于本系统需要的配置
 */
return [
    'identify' => [
        '0' => '可读',
        '1' => '编辑'
    ],
    'reset' => './reset',//重置管理员密码关键所在
    'lockFiles' => './lock',//安装锁
    'envConfig' => '../.env',//配置文件所在位置
    'envExample' => '../.env.example',//例子配置文件
    'nav_option_show' => [//选项列表显示选项 1 显示 后两个 3 不显示
        'show_two' => 1, 
        'hider_nav' => 3,
        ],
    //系统设置-需要后台控制是否开放的功能，只是在安装时需要调用入库, 功能id => 名称, 
    'function' => [
        1 => '注册',
    ],
    //系统设置-方法名对应功能id，在中间件需要检查时使用
    'method_to_id' => [
        'doRegist' => 1,
    ],
    //系统设置-用于后台显示
    'is_used' => [
        1 => '开放',
        0 => '关闭',
    ],
    //系统设置-用于后台显示的操作按钮名
    'setting_operate_name' => [
        0 => '启用',
        1 => '禁用',
    ],
    //用户设置-用户状态值
    'is_used_value' => [
        'use' => 0,
        'stop' => 1,
    ],
    //用户设置-后台显示
    'is_used_name' => [
        1 => '停用',
        0 => '使用中',
    ],
    //用户设置-后台显示操作按钮名
    'user_operate_name' => [
        0 => '禁用',
        1 => '启用',
    ],
    //默认模板地址
    'template' => [
        'API模板' => './template/api',
        '数据字典' => './template/dictionary',
        'Apiary模板' => './template/apiary',
    ],
    'contact' => [
        'Email' => 'wencailuo@qq.com',
        'words' => '使用过程中任何问题请联系我们！',
    ],
];