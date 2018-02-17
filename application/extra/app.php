<?php
/**
 *Created by PhpStorm,
 *User: wangjingxu
 *Date:2018/1/19
 *Time:12:43
 */
return [
    //密码加密言
    'password_pre_halt' => '_#wang_jx',
    'aes_key' => 'sgg45747ss223455',//aes 密钥，服务端和客户端必须保持一致
    'apptypes' => [
        'ios',
        'android',
    ],
    'app_sign_time' => 100000,
    'app_sign_cache_time' => 20,//sign缓存
];
