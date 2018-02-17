<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/1/22
 * Time: 2:48
 */

namespace app\admin\controller;


use think\Exception;

class News extends Base
{
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            //数据需要做校验 validate
            try {
                $id = model('News')->add($data);
            } catch (Exception $exception) {
                return $this->result('',0,'新增失败'.$exception->getMessage());
            }

            if ($id) {
                return $this->result(['jump_url'=>url('news/index')],1,'OK');
            }else{
                return $this->result('',0,'新增失败');
            }
        }else{
            $this->isLogin();
            return $this->fetch('',[
                'cats' => config('cat.lists'),
            ]);
        }
    }

    public function index()
    {
        $data = input('param.');
        $query = http_build_query($data);
        $whereDate = [];
        //转换查询条件
        if (!empty($data['start_time']) && !empty($data['end_time'])
            && $data['end_time'] > $data['start_time']
        ) {
            $whereDate['create_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],
            ];
        }
        if (!empty($data['catid'])) {
            $whereDate['catid'] = intval($data['catid']);
        }
        if (!empty($data['title'])) {
            $whereDate['title'] = ['like','%'.$data['title'].'%'];
        }
//        //获取数据填充到模板

//        //模式一
//        $news = model('News')->getNews();

        //模式二
        // page  size   from     limit from size
        $this->getPageAndSize($data);
//        获取表里的数据
        $news = model('News')->getNewsByCondition($whereDate,$this->from,$this->size);
        //获取数据的总页数
        $total = model('News')->getNewsCount($whereDate);
        //结合总数+size =》有多少页
        $pageTotal = ceil($total/$this->size);
        if ($this->page == $pageTotal) {
            $nlist = $total - $this->from;
        }else{
            $nlist = $this->size;
        }

        return $this->fetch('news/index',[
            'news' => $news,
            'pageTotal' => $pageTotal,
            'nlist' => $nlist,
            'total' => $total,
            'size' => $this->size,
            'curr' => $this->page,
            'cats' => config('cat.lists'),
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'catid' => empty($data['catid']) ? '' : $data['catid'],
            'title' => empty($data['title']) ? '' : $data['title'],
            'query' => $query,
        ]);
    }

    /**
     * 新闻编辑功能
     */
    public function edit()
    {
        $data = input('param.');
        if (request()->isPost()) {
            if (empty($data['is_allowcomments'])) {
                $data['is_allowcomments'] = 0;
            }
            if (empty($data['is_head_figure'])) {
                $data['is_head_figure'] = 0;
            }
            if (empty($data['is_position'])) {
                $data['is_position'] = 0;
            }
            $data['update_time'] = time();
            try {
                $res = model('News')->save($data, ['id' => $data['id']]);
            } catch (Exception $exception) {
                return $this->result('', 0, $exception->getMessage());
            }

            if ($res) {
                return $this->result(['jump_url'=>url('news/index')], 1, 'OK');
            } else {
                return $this->result('', 0, '删除失败');
            }
        }
        $result = model('News')->get($data['id']);

        return $this->fetch('',[
            'result' => $result->getData(),
            'cats' => config('cat.lists'),
        ]);
    }
}