<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crane extends Model
{
    protected $fillable = ['item_id','right_unit_id', 'produce_unit_id', 'is_monitor', 'driver', 'record_no', 'floor_no',
                            'model', 'left_no', 'parameters', 'left_at'] ;

    public function blackBoxes()
    {
        return $this->hasOne(BlackBox::class);
    }
}
