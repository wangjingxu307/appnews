<?php
/**
 *Created by PhpStorm,
 *User: wangjingxu
 *Date:2018/1/27
 *Time:10:03
 */
namespace app\common\lib;

//引入鉴权类
use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;

/**
 * 七牛图片上传基础类库
 * Class Upload
 * @package app\common\lib
 */
class Upload
{
    /**
     * 图片上传
     */
    public static function image()
    {
        if (empty($_FILES['file']['tmp_name'])) {
            exception('您提交的图片数据不合法', 404);
        }
        //要上传的文件
        $file = $_FILES['file']['tmp_name'];
        //方法1获取文件后缀
//        $ext = explode('.', $_FILES['file']['name']);
//        $ext = $ext[1];
        //方法2获取文件后缀
        $ext = pathinfo($_FILES['file']['name']);
        $ext = $ext['extension'];
        $config = config('qiniu');
        $auth = new Auth($config['ak'], $config['sk']);
        $token = $auth->uploadToken($config['bucket']);
        //上传到七牛后保存的文件名
        $key = date('Y') . "/" . date('m') . "/" . substr(md5($file), 0, 5) . date('YmdHis') . rand(0, 9999) . "." . $ext;
//        初始UploadManager类
        $uploadMgr = new UploadManager();
        list($res,$err) = $uploadMgr->putFile($token, $key, $file);
        if ($err !== null) {
            return null;
        } else {
            return $key;
        }
    }
}
