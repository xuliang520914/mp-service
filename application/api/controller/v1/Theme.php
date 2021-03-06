<?php


namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    public function getSimpleList($ids='')
    {
        (new IDCollection())->goCheck();

        $ids = explode(',', $ids);
        $theme = ThemeModel::with(['topicImg', 'headImg'])->select($ids);
        if ($theme->isEmpty()) {
            throw new ThemeException();
        }
        return $theme;
    }

    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $theme = ThemeModel::getThemeWithProduct($id);
        if ($theme->isEmpty()) {
            throw new ThemeException();
        }
        return $theme;
    }
}