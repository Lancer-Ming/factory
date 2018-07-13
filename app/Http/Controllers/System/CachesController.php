<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CachesController extends Controller
{
    public function delete()
    {
        \Cache::flush();
        return successJson('', '清除成功！');
    }
}
