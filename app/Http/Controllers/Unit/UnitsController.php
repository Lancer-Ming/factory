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
            $units = Unit::where($where)->with([
                'utypes' => function($query) use ($request) {
                    $query->whereIn('id', $request->utype_id);
                }
            ])->paginate(10);
        } else {
            $units = Unit::where($where)->orderBy('created_at', 'desc')->with('utypes')->paginate(10);
        }

        return successJson($units);
    }
}
