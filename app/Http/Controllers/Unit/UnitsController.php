<?php

namespace App\Http\Controllers\Unit;

use App\Models\Unit;
use App\Models\Utype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitsController extends Controller
{
    public function index(Request $request)
    {
        $where = function($query) use ($request) {
            if ($request->has('name') && trim($request->name) != '') {
                $query->where('name', 'like', '%'.$request->name.'%');
            }

            if ($request->has('leader') && trim($request->leader) != '') {
                $query->where('leader', 'like', '%'.$request->leader.'%');
            }
        };

        if ($request->has('utype_id') && count($request->utype_id) > 0) {
            // 先查询出unit的id
            $unit_ids = \DB::table('unit_utype')->whereIn('utype_id', $request->utype_id)->pluck('unit_id')->unique();
            $units = Unit::where($where)->whereIn('id', $unit_ids)->orderBy('created_at', 'desc')->with('utypes')->paginate(10);
        } else {
            $units = Unit::where($where)->orderBy('created_at', 'desc')->with('utypes')->paginate(10);
        }

        return successJson($units);
    }
}
