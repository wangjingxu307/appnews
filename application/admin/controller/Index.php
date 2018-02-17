<?php
namespace app\admin\controller;


class Index extends Base
{
    public function index()
    {
//        halt(session(config("admin.session_user"), "", config("admin.session_user_scope")));
        $this->isLogin();
        return $this->fetch();
    }

    public function welcome(){
        return $this->fetch();
    }

}
