<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dust extends Model
{
    protected $guarded = ["pagesize","page"];

    public function saveUnit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function installUnit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function dustStandard()
    {
        return $this->hasOne(DustStandard::class, 'sn', 'sn');
    }
}
