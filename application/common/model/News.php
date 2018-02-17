<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/1/29
 * Time: 16:41
 */

namespace app\common\model;



class News extends Base
{

    /**
     * 后台自动化分页
     * @param array $data
     * @return array
     */
    public function getNews($data = [])
    {
        $data['status'] = [
            'neq', config('code.status_delete'),
        ];
        $order = ['id' => 'desc'];

        //查询
        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
    }

    /**
     * 根据条件来获取列表数据
     * @param array $param
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNewsByCondition($condition=[],$from=0,$size=1)
    {
        $condition['status'] = [
            'neq', config('code.status_delete'),
        ];

        $order = ['id' => 'desc'];

        $result = $this->where($condition)
            ->limit($from,$size)
            ->order($order)
            ->select();

        return $result;
    }

    /**
     * 获取新闻总数
     * @param array $param
     * @return int|string
     */
    public function getNewsCount($condition=[])
    {
        $condition['status'] = [
            'neq', config('code.status_delete'),
        ];
        return $this->where($condition)
            ->count();

    }
}