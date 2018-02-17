<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/1/22
 * Time: 3:15
 */

namespace app\admin\controller;
use app\common\lib\Upload;
use think\Exception;
use think\Request;

/**
 * 后台图片上传相关逻辑
 * Class Image
 * @package app\admin\controller
 */
class Image extends Base
{
    /**
     * 图片上传
     */
    public function upload0()
    {
        $file = Request::instance()->file('file');
        //把图片上传到指定文件夹
        $info = $file->move('upload');
        if ($info && $info->getPathname()) {
            $data = [
                'status' => 1,
                'message' => 'ok',
                'data' => '/'.$info->getPathname(),
            ];
            echo json_encode($data);
            exit();
        }
        echo json_encode(['status' => 0, 'message' => '上传失败']);
    }

    /**
     * 七牛图片上传
     */
    public function upload()
    {
        try {
        } catch (Exception $exception) {
            echo json_encode(['status' => 0, 'message' => $exception->getMessage()]);
        }
        $image = Upload::image();
        if ($image) {
            $data = [
                'status' => 1,
                'message' => 'ok',
                'data' => config('qiniu.image_url') . "/" . $image,
            ];
            echo json_encode($data);
            exit();
        } else {
            echo json_encode(['status' => 0, 'message' => '上传失败']);
        }
    }
}