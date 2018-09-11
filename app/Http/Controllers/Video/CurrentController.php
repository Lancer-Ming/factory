<?php

namespace App\Http\Controllers\Video;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrentController extends Controller
{
    public function index()
    {
        // 获取 当前用户拥有的项目
        $item_ids = User::prossessItemId();

        $data = Item::with('devices')->select('name as d_name', 'id')->whereIn('id', $item_ids)->orderBy('created_at', 'desc')->get();
        return successJson($data);
    }
}
