<?php

namespace App\Http\Controllers\Video;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DustVideoController extends Controller
{
    public function index(Request $request)
    {
        $items =  Item::with('dusts', 'buildUnit')->paginate(30);
        foreach($items as $item) {

        }
    }
}
