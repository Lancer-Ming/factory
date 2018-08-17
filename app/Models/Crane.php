<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crane extends Model
{
    protected $fillable = ['item_id','right_id', 'crane_produce_id', 'is_monitor', 'driver', 'record_no', 'floor_no',
                            'c_model', 'left_no', 'parameters', 'left_at'] ;

    public function blackBoxes()
    {
        return $this->hasOne(BlackBox::class);
    }

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
