<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackBox extends Model
{
    protected $table = 'blackboxes';
    protected $fillable = ['install_unit_id', 'crane_id', 'sn', 'GPRS', 'validity_month', 'model', 'paid_at', 'installed_at',
                            'function_config', 'identify'];
}
