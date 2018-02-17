<?php
/**
 *Created by PhpStorm,
 *User: wangjingxu
 *Date:2018/2/11
 *Time:11:19
 */
namespace app\common\lib\exception;

use Exception;
use think\exception\Handle;

class ApiHandleException extends Handle
{
    //Http的状态码
    public $httpCode = 500;

    public function render(Exception $e)
    {
        if (config('app_debug') == true) {
            return parent::render($e);
        }
        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
        }
        return show(0, $e->getMessage(), [], $this->httpCode);
    }
}
