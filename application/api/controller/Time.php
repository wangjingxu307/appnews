<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/2/6
 * Time: 15:27
 */
namespace app\api\controller;
use think\Controller;

class Time extends Controller
{
    public function index()
    {
        return show(1, 'OK', time());
    }
}