<?php

namespace app\api\model;

class Theme extends BaseModel
{
    protected $hidden = ['topic_img_id', 'head_img_id', 'update_time', 'delete_time'];

    public function topicImg()
    {
        return $this->belongsTo(Image::class, 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo(Image::class, 'head_img_id', 'id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'theme_product', 'product_id', 'theme_id');
    }

    /**
     * 获取单个主题
     *
     * @param $id
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getThemeWithProduct($id)
    {
        return self::with('product,topicImg,headImg')->find($id);
    }
}
