<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/1/21
 * Time: 6:41
 */

namespace app\common\validate;


use think\Validate;

class LoginUser extends Validate
{
    protected $rule = [
        'username|用户名' => 'require',
        'password|密码' => 'require',
        'code|验证码' => 'require|captcha',
    ];

    protected $message = [
        'username' => ['require' => '用户名不能为空，请检查!'],
        'password' => ['require' => '密码不能为空，请检查!'],
        'code' => [
            'require' => '验证码不能为空，请检查!',
            'captcha' => '验证码错误，请检查!',
        ],
    ];
}