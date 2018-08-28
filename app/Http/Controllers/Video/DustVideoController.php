<?php

namespace App\Http\Controllers\Video;

use App\Models\Dust;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DustVideoController extends Controller
{
    public function index(Request $request)
    {
        $items =  Item::with(['dusts:item_id,sn,is_online', 'buildUnit:name'])->select('id', 'name', 'item_no', 'permit_no')->paginate(30);

        foreach($items as $key => &$value) {
            $value['b_unit'] = $value->buildUnit->implode('name');
            $value['online_count'] = Dust::where(['item_id'=> $value['id'], 'is_online' => 1])->count();
            unset($value->buildUnit);
        }
        return $items;

    }
}
