<?php


namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\facade\Log;
use think\facade\Request;

class ExceptionHandler extends Handle
{
    /** @var HTTP请求状态码 */
    private $code;

    /** @var 错误信息 */
    private $msg;

    /** @var 自定义错误码 */
    private $errorCode;

    public function render(Exception $e)
    {
        if($e instanceof BaseException) {
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            if (config('app_debug')) {
                return parent::render($e);
            }
            $this->code = 500;
            $this->msg = '服务器错误';
            $this->errorCode = '999';
            $this->recordErrorLog($e);
        }

        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url(),
        ];
        return json($result, $this->code);
    }

    public function recordErrorLog(Exception $e)
    {
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(), 'error');
    }
}