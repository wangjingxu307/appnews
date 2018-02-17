<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/2/6
 * Time: 15:27
 */
namespace app\api\controller;
use app\common\lib\exception\ApiException;
use think\Controller;

class Test extends Common
{
    public function index()
    {
        return [
            'test1',
            'test2'
        ];
    }

    public function update($id = 0)
    {
//        $id = input('put.');
//        return $id;
        halt(input('put.'));
    }

    /**
     * 新增
     * @return mixed
     */
    public function save()
    {
        $date = input('post.');
        return show(1, 'OK', input('post.'), 201);
    }

}