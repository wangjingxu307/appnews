<?php
/**
 *Created by PhpStorm,
 *User: wangjingxu
 *Date:2018/1/12
 *Time:19:19
 */
namespace app\common\validate;

use think\Validate;

class AdminUser extends Validate

{
    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|max:20',
    ];
}
