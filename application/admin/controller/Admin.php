<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/1/12
 * Time: 19:04
 */

namespace app\admin\controller;


use app\common\lib\IAuth;
use think\Controller;
use think\Exception;

class Admin extends Controller
{
    public function add()
    {
//        判断是否是POST提交
        if (request()->isPost()) {
//            打印提交数据
//            dump(input('post.'));
            $data = input('post.');
//            validate
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $data['password'] = IAuth::setPassword($data['password']);
            $data['status'] = 1;
            try {
                $id = model('AdminUser')->add($data);
            } catch (Exception $exception) {
                $this->error($exception->getMessage());
            }
            if ($id) {
                $this->success('id=' . $id.'的用户添加成功');
            } else {
                $this->error('error');
            }
        }else{
            return $this->fetch();
        }
    }

}