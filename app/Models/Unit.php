<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = ['address', 'utypes'];

    public function utypes()
    {
        return $this->belongsToMany(Utype::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
