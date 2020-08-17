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
}
