<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'region';
    protected $guarded = [];
    public $timestamps = false;

    protected static function getAllRegions()
    {
        return self::where('sort', 'desc')->with();
    }

    public function children()
    {
        return $this->hasMany('');
    }
}
