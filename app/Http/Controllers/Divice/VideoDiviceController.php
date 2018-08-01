<?php

namespace App\Http\Controllers\Divice;

use App\Models\Divice;
use App\Models\Ys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoDiviceController extends Controller
{
    public function index()
    {
        $where = function($query) use ($request) {
            if ($request->has('d_name') && trim($request->d_name != '')) {
                $query->where('d_name', 'like', '%'.$request->d_name.'%');
            }
        };

        $pagesize = $request->has('pagesize') ? $request->pagesize: 10;
        $videoDivices = Divice::where($where)->with('ys_id')->paginate($pagesize);

        return successJson($videoDivices);
    }

    public function store(Request $request)
    {
        $ysData = $request->only('appkey', 'secret', 'access_token', 'username', 'password', 'phone');
        $ys = Ys::create($ysData);

        $videoDiviceData = $request->only('d_name', 'serial', 'validate_code', 'item_id');
        $videoDiviceData['ys_id'] = $ys->id;
        Divice::create($videoDiviceData);

        $videoDivices = Divice::with('ys')->get();

        return successJson($videoDivices);
    }
}
