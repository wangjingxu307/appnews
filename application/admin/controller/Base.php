<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/1/20
 * Time: 11:34
 */

namespace app\admin\controller;
use think\Controller;
use think\Exception;
use think\Session;


/**
 * 后台基本类库
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    //page 页数
    protected $page = '';
    //size 每页多少条
    protected $size = '';
    //查询条件的起始值
    protected $from = 0;
    //定义model
    protected $model = '';
    /**
     * 初始化方法
     */
    protected function _initialize()
    {
        parent::_initialize();
        //定义用户
        define('USER_ID', Session::get(config("admin.session_user_id")));
    }
    //如果是未登录的用户
    protected function isLogin()
    {
        if (empty(USER_ID)) {
            $this->error('用户未登录，无权访问', url('login/login'));
        }
    }

    //如果是已经登录的用户
    protected function alreadyLogin()
    {
        if (!empty(USER_ID)) {
            $this->error('用户已经登录，请勿重复登录', url('index/index'));
        }
    }

    /**
     * 获取分页的page 和size内容
     * @param $data
     */
    protected function getPageAndSize($data)
    {
        $this->page = $whereDate['page'] = empty($data['page']) ? 1 : $data['page'];
        $this->size = $whereDate['size'] = empty($data['size']) ? config('paginate.list_rows') : $data['size'];
        $this->from = ($this->page - 1) * $this->size;
    }

    /**
     * 删除的逻辑
     * @param int $id
     */
    public function delete($id = 0)
    {
        if (!intval($id)) {
            return $this->result('', 0, 'ID不合法');
        }
        $model = $this->model ? $this->model : request()->controller();

        try {
            $res = model($model)->save(['status' => config('code.status_delete')], ['id' => $id]);
        } catch (Exception $exception) {
            return $this->result('', 0, $exception->getMessage());
        }

        if ($res) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'OK');
        } else {
            return $this->result('', 0, '删除失败');
        }
    }

    /**
     * 修改状态的逻辑
     */
    public function status()
    {
        $data = input('param.');
        //validate校验

        //通过id 去库里查询数据是否存在

        $model = $this->model ? $this->model : request()->controller();

        try {
            $res = model($model)->save(['status' => $data['status']], ['id' => $data['id']]);
        } catch (Exception $exception) {
            return $this->result('', 0, $exception->getMessage());
        }

        if ($res) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'OK');
        } else {
            return $this->result('', 0, '删除失败');
        }
    }

}