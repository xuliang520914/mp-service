<?php


namespace app\lib\exception;


class WeChatException extends BaseException
{
    /** @var HTTP请求状态码 */
    public $code = 400;

    /** @var 错误信息 */
    public $msg = '微信服务器接口调用失败';

    /** @var 自定义错误码 */
    public $errorCode = '999';
}