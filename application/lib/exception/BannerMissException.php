<?php


namespace app\lib\exception;


class BannerMissException extends BaseException
{
    /** @var HTTP请求状态码 */
    public $code = 404;

    /** @var 错误信息 */
    public $msg = '请求的banner不存在';

    /** @var 自定义错误码 */
    public $errorCode = '40000';
}