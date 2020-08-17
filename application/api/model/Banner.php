<?php
namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden = ['update_time', 'delete_time'];

    public static function getBannerById($id)
    {
        $banner = self::with(['items', 'items.img'])->find($id);
        return $banner;
    }

    /**
     * 关联banner_item表
     *
     * @return \think\model\relation\HasMany
     */
    public function items()
    {
        return $this->hasMany(BannerItem::class, 'banner_id', 'id');
    }
}