<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utype extends Model
{
    protected $guarded = [];

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'unit_utype');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function judgeFloor($id)
    {
        $utype = self::find($id);
        if ($utype->parent_id == 0) {
            return 1;
        } elseif (self::find($utype->parent_id)->parent_id == 0) {
            return 2;
        } else {
            return 3;
        }


    }
}
