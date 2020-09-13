<?php


namespace app\api\Service;


use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;

    protected $wxMpAppId;

    protected $wxMpAppSecret;

    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxMpAppId = config('wx.app_id');
        $this->wxMpAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxMpAppId, $this->wxMpAppSecret, $this->code);
    }

    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);

        if (empty($wxResult)) {
            $this->processLoginError($wxResult);
        }

        $loginFail = array_key_exists('errcode', $wxResult);

        if (!$loginFail) {
            return $this->grantToken($wxResult);
        }
    }

    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }

    private function grantToken($wxResult)
    {
        // 获取到openid
        $openid = $wxResult['openid'];

        // 验证数据是否已经存在
        $user = UserModel::getByOpenId($openid);
        if ($user) {
            $uid = $user->id;
        } else {
            // 不存在，新增，存在，不操作
            $uid = $this->newUser($openid);
        }

        // 生成令牌,记录令牌
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);

        // 返回令牌给客户端
        return $token;
    }

    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid' => $openid
        ]);

        return $user->id;
    }

    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;
        return $cachedValue;
    }

    private function saveToCache($cacheValue)
    {
        $key = self::generateToken();

        $value = json_encode($cacheValue);

        $expireIn = config('setting.token_expire_in');

        $request = cache($key, $value, $expireIn);

        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }

        return $key;
    }
}