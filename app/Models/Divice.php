<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divice extends Model
{
    protected $guarded = [];

    public function ys()
    {
        return $this->belongsTo(Ys::class);
    }
}
