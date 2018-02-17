<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function pagination($obj){
    if (!$obj) {
        return '';
    }

    $params = request()->param();
    return '<div class="imooc-app">' . $obj->appends($params)->render() . '</div>';
}

/**
 * 获取栏目名称
 * @param $catId
 * @return string
 */
function getCatName($catId)
{
    if (!$catId) {
        return '';
    }

    $cats = config('cat.lists');

    return !empty($cats[$catId]) ? $cats[$catId] : '';
}

/**
 * 显示是否推荐
 * @param $str
 * @return string
 */
function isYesNo($str)
{
    return $str ? '<span style="color:red">是</span>' : '<span>否</span>';
}

/**
 * 状态修改
 * @param $id
 * @param $status
 */
function status($id, $status)
{
    //需对$id,$status进行校验
    //...
    $controller = request()->controller();

    $sta = $status == 1 ? 0 : 1;

    $url = url($controller . '/status', ['id' => $id, 'status' => $sta]);

    if ($status == 1) {
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='app_status(this)'><span class='label label-success radius'>正常</span></a>";
    } elseif ($status == 0) {
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='app_status(this)'><span class='label label-danger radius'>待审</span></a>";
    }

    return $str;
}

/**
 * 通用化api接口数据输出
 * @param int $status
 * @param string $message
 * @param array $data
 * @param int $httpCode
 * @return array
 */
function show($status = 0, $message = '', $data = [], $httpCode = 200)
{
    $data = [
        'status' => $status,
        'message' => $message,
        'data' => $data,
    ];
    return json($data, $httpCode);
}

