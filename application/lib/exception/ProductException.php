<?php


namespace app\lib\exception;


class ProductException extends BaseException
{
    /** @var HTTP请求状态码 */
    public $code = 404;

    /** @var 错误信息 */
    public $msg = '指定商品不存在，请检查参数';

    /** @var 自定义错误码 */
    public $errorCode = '20000';
}