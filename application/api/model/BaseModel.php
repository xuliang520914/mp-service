<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected function prefixImageUrl($value, $data)
    {
        $url = $value;
        if ($data['from']) {
            $url = config('setting.img_prefix') . $value;
        }
        return $url;
    }
}
