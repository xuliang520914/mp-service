<?php
namespace app\api\validate;

use app\lib\exception\ParameterException;
use Exception;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);

        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
            ]);

            throw $e;
        }
        return true;
    }

    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return false;
    }

    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    public function getDataByRule($array)
    {
        if (array_key_exists('user_id', $array) | array_key_exists('uid', $array)) {
            // 防止提交参数篡改用户id外键
            throw new ParameterException([
                'msg' => '参数中包含非法参数名user_id或者uid'
            ]);
        }

        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $array[$key];
        }

        return $newArray;
    }
}