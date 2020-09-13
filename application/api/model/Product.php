<?php

namespace app\api\model;

use app\api\validate\IDMustBePositiveInt;

class Product extends BaseModel
{
    protected $hidden = ['pivot', 'from', 'category_id', 'update_time', 'delete_time'];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImageUrl($value, $data);
    }

    public function imgs()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany(ProductProperty::class, 'product_id', 'id');
    }
    
    public static function getMostRecent($count)
    {
        return self::limit($count)
            ->order('create_time', 'desc')->select();
    }

    public static function getProductByCategory($categoryId)
    {
        return self::where('category_id', '=', $categoryId)->select();
    }

    public static function getProductDetail($id)
    {
        return self::with(['imgs' => function ($query) {
            $query->with(['imgUrl'])->order('order', 'asc');
        }, 'properties'])->find($id);
    }
}
