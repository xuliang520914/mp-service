<?php

namespace app\api\model;

class Category extends BaseModel
{
    protected $hidden = ['topic_img_id', 'update_time', 'delete_time'];

    public function img()
    {
        return $this->belongsTo(Image::class, 'topic_img_id', 'id');
    }
}
