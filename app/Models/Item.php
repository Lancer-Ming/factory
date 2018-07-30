<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function itemUnit()
    {
        return $this->hasMany(ItemUnit::class);
    }

    public static function getItems()
    {
        return self::where($where)->with([
            'itemUnit' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->orderBy('created_at', 'desc')->get();
    }
}
