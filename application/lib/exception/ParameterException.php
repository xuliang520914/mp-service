<?php


namespace app\lib\exception;


class ParameterException extends BaseException
{
    /** @var HTTP请求状态码 */
    public $code = 400;

    /** @var 错误信息 */
    public $msg = '参数错误';

    /** @var 自定义错误码 */
    public $errorCode = '10000';
}