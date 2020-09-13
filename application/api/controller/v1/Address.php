<?php

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\api\Service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address
{
    public function createOrUpdateAddress()
    {
        $addressValidate = new AddressNew();
        $addressValidate->goCheck();

        // 根据Token获取uid
        $uid = TokenService::getCurrentUid();

        // 根据uid查出用户信息是否存在，不存在则数据异常
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }

        // 获取提交的地址信息
        $dataArray = $addressValidate->getDataByRule(input('post.'));

        // 根据地址是否存在，判断新增还是修改
        $userAddress = $user->address;
        if (!$userAddress) {
            $user->address()->save($dataArray);
        } else {
            $user->address->save($dataArray);
        }

        return new SuccessMessage();
    }
}
