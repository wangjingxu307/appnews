<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/1/20
 * Time: 11:34
 */

namespace app\admin\controller;


/**
 * 后台测试控制器
 * Class Test
 * @package app\admin\controller
 */
class Test extends Base
{
    public function test()
    {
        return $this->fetch();
    }
}