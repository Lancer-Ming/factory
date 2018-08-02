<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = [];
    protected $table = 'divices';

    public function ys()
    {
        return $this->belongsTo(Ys::class);
    }
}
