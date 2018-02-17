<?php
namespace app\admin\controller;

use app\common\lib\IAuth;
use think\Controller;
use think\Exception;
use think\Request;
use think\Session;

class Login extends Base
{
    public function login()
    {
        $this->alreadyLogin();
        return $this->fetch();
    }

    /**
     * 用户登录相关业务
     * @param Request $request
     * @return array
     */
    public function check(Request $request)
    {
        //初始返回参数
        $status = 0;
        $result = '';
        $data = $request->param();

        if ($request->isPost()) {
            //判断基本信息
            $validate = validate("LoginUser");
            if ($validate->check($data)) {
                try {
                    $user = model('AdminUser')->get(['username'=>$data['username']]);
                } catch (Exception $exception) {
                    $exception->getMessage();
                }
                if ($user == null || $user->status != config("code.status_normal") ){
                    $result = "该用户不存在!";
                }elseif (IAuth::setPassword($data['password']) != $user['password']){
                    $result = "密码不正确!";
                } else {
                    $status = 1;
                    $result = "登录成功";
                    Session::set(config("admin.session_user"), $user->getData());
                    Session::set(config("admin.session_user_id"), $user->id);
                }
            }else{
                $result = $validate->getError();
            }
        } else {
            $result = "请求不合法!";
        }

        return ['status'=>$status,'message'=>$result,'data'=>$data];
    }

    /**
     * 退出登录的逻辑
     * 1、清空session
     * 2、跳转到登录页面
     */
    public function logout()
    {
        Session::delete(config("admin.session_user"));
        //跳转
        $this->redirect("login/login");
    }

}
