<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;


class DustInfo extends Model
{
    protected $guarded = [];

    public function dust()
    {
        return $this->belongsTo(\App\Models\Dust::class, 'sn', 'sn');
    }
}
