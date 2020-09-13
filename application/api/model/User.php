<?php

namespace app\api\model;

use think\Model;

class user extends BaseModel
{
    public function address()
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'id');
    }

    public static function getByOpenId($openid)
    {
        return self::where('openid', '=', $openid)->find();
    }
}
