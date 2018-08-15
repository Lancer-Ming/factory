<?php

namespace App\Http\Controllers\Unit;

use App\Http\Requests\UnitRequest;
use App\Models\Permission;
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

        $pagesize = $request->has('pagesize') ? $request->pagesize: 30;

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

    public function import(Request $request) {
        if ($request->has('finalExcelData')) {
            $storeData = $request->finalExcelData;
            forEach($storeData as $key=> $value) {
                unset($storeData[$key]['utype_id']);
                unset($storeData[$key]['id']);
                $storeData[$key]['created_at'] = date('Y-m-d H:i:s', time());
                $storeData[$key]['updated_at'] = date('Y-m-d H:i:s', time());
                $unit = Unit::create($storeData[$key]);
                $unit->utypes()->attach($value['utype_id']);
            }
            $pagesize = $request->has('pagesize') ? $request->pagesize: 10;
            $units = Unit::orderBy('created_at', 'desc')->with('utypes')->paginate($pagesize);
            return successJson($units, '操作成功！');
        }
        if ($request->has('utypes') && count($request->utypes) > 0) {
            $data['utype_id'] = Utype::whereIn('name', $request->utypes)->pluck('id');
        }
        if ($request->has('parent_unit') && $request->parent_unit != '') {
            $data['parent_id'] = Unit::where('name', $request->parent_unit)->first()->id;
        }
        return successJson($data);
    }

    public function form(Request $request)
    {
        $where = function($query) use ($request) {
            if ($request->has('name') && trim($request->name) != '') {
                $query->where('name', 'like', '%'.$request->name.'%');
            }
        };
        $pagesize = $request->has('pagesize') ? $request->pagesize: 10;

        if ($request->has('form_name') && trim($request->form_name) != '') {
            $utype = Utype::where('form_name', $request->form_name)->first();
            if(isset($utype)) {
                $utype_id = $utype->id;
            }
            $unit_ids = \DB::table('unit_utype')->where('utype_id', $utype_id)->pluck('unit_id')->unique();
            $units = Unit::whereIn('id', $unit_ids)->where($where)->orderBy('created_at', 'desc')->with('utypes')->paginate($pagesize);
        } else {
            $units = Unit::where($where)->orderBy('created_at', 'desc')->with('utypes')->paginate($pagesize);
        }

        return successJson($units);
    }
}
