<?php


namespace app\api\Service;


use app\lib\exception\TokenException;
use think\Exception;
use think\facade\Cache;
use think\facade\Request;

class Token
{
    public static function generateToken()
    {
        // 生成32个字符组成的随机字符串
        $randStr = getRandChar(32);

        $timestamp = $_SERVER['REQUEST_TIME'];

        $salt = config('secure.token_salt');

        return md5($randStr . $timestamp . $salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');

        $vars = Cache::get($token);

        if (!$vars) {
            throw new TokenException();
        }

        if (!is_array($vars)) {
            $vars = json_decode($vars, true);
        }

        if (!array_key_exists($key, $vars)) {
           throw new Exception('获取的token变量不存在');
        }
        return $vars[$key];
    }
    
    public static function getCurrentUid()
    {
        return self::getCurrentTokenVar('uid');
    }
}