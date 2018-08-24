<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    /**项目与单位的对应关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function units()
    {
        return $this->belongsToMany(Unit::class,'item_units', 'item_id', 'contract_id')
            ->withPivot('contract_id', 'subcontract_id', 'build_id', 'supervisor_id', 'servey_id', 'design_id', 'trail_id', 'safety_station_id');
    }

    /** 视频监控设备
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function dusts()
    {
        return $this->hasMany(Dust::class);
    }

    public function buildUnit()
    {
        return $this->belongsToMany(Unit::class, 'item_units', 'item_id', 'build_id');
    }

    public static function getItems()
    {
        return self::with([
            'units' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->orderBy('created_at', 'desc')->get();
    }
}
