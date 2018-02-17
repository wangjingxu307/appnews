<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/1/19
 * Time: 12:39
 */
namespace app\common\lib;
use think\Cache;

/**
 * Iauth相关
 * Class IAuth
 */
class IAuth
{
    /**
     * 设置密码
     * @param String $data
     * @return string
     */
    public static function setPassword($data)
    {
        return md5($data . config("app.password_pre_halt"));
    }

    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data = [])
    {
        ksort($data);
        $string = http_build_query($data);
        $string = (new Aes())->encrypt($string);
        return $string;
    }

    /**
     * 检查sign是否正常
     * @param $headers
     * @return bool
     */
    public static function checkSignPass($headers)
    {
        $str = (new Aes())->decrypt($headers['sign']);
        if (empty($str)) {
            return false;
        }
        parse_str($str, $arr);

        if (!is_array($arr) || empty($arr['did']) || $arr['did'] != $headers['did']) {
            return false;
        }

        if (!config('app_debug')) {

            if (time() - ceil($arr['time']/1000) > config('app.app_sign_time')) {
                return false;
            }

            //sign的唯一性
            if (Cache::get($headers['sign'])) {
                return false;
            }
        }

        return true;
    }
}