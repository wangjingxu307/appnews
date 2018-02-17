<?php
/**
 *Created by PhpStorm,
 *User: wangjingxu
 *Date:2018/2/16
 *Time:16:46
 */
namespace app\common\lib;

/**
 * 时间
 * Class Time
 * @package app\common\lib
 */
class Time
{
    public static function get13TimeStamp()
    {
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);
    }
}
