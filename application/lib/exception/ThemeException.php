<?php


namespace app\lib\exception;


class ThemeException extends BaseException
{
    /** @var HTTP请求状态码 */
    public $code = 404;

    /** @var 错误信息 */
    public $msg = '指定主题不存在，请检查ID';

    /** @var 自定义错误码 */
    public $errorCode = '30000';
}