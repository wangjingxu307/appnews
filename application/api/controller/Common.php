<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/2/12
 * Time: 11:15
 */

namespace app\api\controller;


use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use app\common\lib\Time;
use think\Cache;
use think\Controller;
/**
 * API模块公共的控制器
 * Class Common
 * @package app\api\controller
 */
class Common extends Controller
{
    //header头信息
    public $headers = '';
    /**
     * 初始化构造方法
     */
    public function _initialize()
    {
        $this->checkRequestAuth();
//        $this->testAes();
//        $this->testHeaders();
    }

    /**
     * 检查每次app请求的数据是否合法
     */
    public function checkRequestAuth()
    {
        //首先需要获取headers
        $headers = request()->header();

        //基础参数校验
        if (empty($headers['sign'])) {
            throw new ApiException('sign不存在', 400);
        }
        if (!in_array($headers['app_type'],config('app.apptypes'))) {
            throw new ApiException('app_type不合法', 400);
        }

        //需要sign
        if (!IAuth::checkSignPass($headers)) {
            throw new ApiException('授权码sign失败', 401);
        }

        Cache::set($headers['sign'],1,config('app.app_sign_cache_time'));

        $this->headers = $headers;

}


    public function testAes()
    {
        $data = [
            'did' => '12345dg',
            'version' => 1,
            'time' => Time::get13TimeStamp(),
        ];
//        $str = 'c2dnNDU3NDdzczIyMzQ1NWJiaVVNSmVRQVJ2bWg3cFpJUjRoMzBINTNqYkRHZmFiR0JHVkJxWVZTTEU9';
//        $str = 'q3SFKfIuKTnqQCuA5px9ylh6TmxQL2c0T0hob3VtWWJyNnVVbk1lMjQxd3BoeFJ1Q2JIWFlMS3J0KzcvOTVtNURSRVZXbUZicVZrQ3RjMGs=';
        echo IAuth::setSign($data);
//        echo (new Aes())->decrypt($str);
        exit();
    }

    public function testHeaders()
    {
        $headers = request()->header();
        halt($headers);
    }
}