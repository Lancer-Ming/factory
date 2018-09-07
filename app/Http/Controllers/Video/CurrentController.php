<?php

namespace App\Http\Controllers\Video;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrentController extends Controller
{
    public function index()
    {
        $data = Item::with('devices')->select('name as d_name', 'id')->orderBy('created_at', 'desc')->get();
        return successJson($data);
    }
}
