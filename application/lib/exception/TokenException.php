<?php


namespace app\lib\exception;


class TokenException extends BaseException
{
    /** @var HTTP请求状态码 */
    public $code = 401;

    /** @var 错误信息 */
    public $msg = 'Token已过期或者Token无效';

    /** @var 自定义错误码 */
    public $errorCode = '10001';
}