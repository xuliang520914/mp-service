<?php


namespace app\lib\exception;


class CategoryException extends BaseException
{
    /** @var HTTP请求状态码 */
    public $code = 404;

    /** @var 错误信息 */
    public $msg = '类目不存在';

    /** @var 自定义错误码 */
    public $errorCode = '50000';
}