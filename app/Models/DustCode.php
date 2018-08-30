<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DustCode extends Model
{
    protected $guarded = [];

    public function dust()
    {
        return $this->belongsTo(Dust::class, 'sn', 'sn');
    }
}
