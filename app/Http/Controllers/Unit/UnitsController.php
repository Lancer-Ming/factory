<?php

namespace App\Http\Controllers\Unit;

use App\Http\Requests\UnitRequest;
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

        $pagesize = $request->has('pagesize') ? $request->pagesize: 10;
        if ($request->has('utype_id') && count($request->utype_id) > 0) {
            // 先查询出unit的id
            $unit_ids = \DB::table('unit_utype')->whereIn('utype_id', $request->utype_id)->pluck('unit_id')->unique();
            $units = Unit::where($where)->whereIn('id', $unit_ids)->orderBy('created_at', 'desc')->with('utypes')->paginate($pagesize);
        } else {
            $units = Unit::where($where)->orderBy('created_at', 'desc')->with('utypes')->paginate($pagesize);
        }

        return successJson($units);
    }

    public function edit(Unit $unit)
    {
        $unit->utypes =  $unit->utypes;
        return successJson($unit);
    }

    public function find(Unit $unit)
    {
        return successJson(['label' => $unit->parent->name, 'value' => $unit->parent_id]);
    }

    public function update(UnitRequest $request, Unit $unit) {
        $updateData = $request->except('utype_id');
        $unit->update($updateData);
        $unit->utypes()->sync($request->utype_id);

        $unit->utypes = $unit->utypes;
        return successJson($unit, '操作成功！');
    }

    public function store(UnitRequest $request)
    {
        $storeData = $request->except(['utype_id', 'address', 'utypes', 'pagesize']);
        $unit = Unit::create($storeData);
        $unit->utypes()->attach($request->utype_id);

        $pagesize = $request->has('pagesize') ? $request->pagesize: 10;
        $units = Unit::orderBy('created_at', 'desc')->with('utypes')->paginate($pagesize);
        return successJson($units, '操作成功！');
    }

    public function destroy(UnitRequest $request)
    {
        Unit::destroy($request->id);
        $pagesize = $request->has('pagesize') ? $request->pagesize: 10;
        $units = Unit::orderBy('created_at', 'desc')->with('utypes')->paginate($pagesize);
        return successJson($units, '操作成功！');
    }

    public function export(Request $request)
    {
        if ($request->has('id') && count($request->id) > 0) {
            $units = Unit::whereIn('id',$request->id)->orderBy('created_at', 'desc')->with('utypes', 'parent')->get();
            return successJson($units);
        }
    }
}
