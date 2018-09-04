<?php

namespace App\Http\Controllers\Item;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('name') && trim($request->name) !== '') {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
        };

        $items = Item::where($where)->with(['units' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->orderBy('created_at', 'desc')->get()->toArray();

        if ($request->has('name') && trim($request->name) !== '') {
            $unit_ids = Unit::where($where)->pluck('id');
            $item_ids = \DB::table('item_units')->whereIn('contract_id', $unit_ids)->pluck('item_id');
            $items2 = Item::whereIn('id', $item_ids)->with(['units' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])->orderBy('created_at', 'desc')->get()->toArray();

            $result = array_unique(array_merge($items, $items2));
            return successJson($result);
        }

        return successJson($items);
    }

    public function store(ItemRequest $request)
    {
        $item = Item::create(['item_category_id' => $request->item_category_id, 'invest_id' => $request->invest_id, 'build_type_id' => $request->build_type_id, 'structural_type_id' => $request->structural_type_id, 'item_no' => $request->item_no, 'project_no' => $request->project_no, 'country' => $request->country, 'province' => $request->province, 'city' => $request->city, 'county' => $request->county, 'detail' => $request->detail, 'permit_no' => $request->permit_no, 'area' => $request->area, 'total_amount' => $request->total_amount, 'chargeman' => $request->chargeman, 'chargeman_tel' => $request->chargeman_tel, 'gps' => $request->gps, 'received_at' => $request->received_at, 'started_at' => $request->started_at, 'ended_at' => $request->ended_at, 'started_at' => $request->started_at, 'name' => $request->name,]);

        ItemUnit::insert(['item_id' => $item->id, 'contract_id' => $request->contract_id, 'subcontract_id' => $request->subcontract_id, 'supervisor_id' => $request->supervisor_id, 'servey_id' => $request->servey_id, 'design_id' => $request->design_id, 'trail_id' => $request->trail_id, 'safety_station_id' => $request->safety_station_id,]);

        $items = Item::getItems();

        return successJson($items, '操作成功！');
    }

    public function edit(Item $item)
    {
        $data = $item;
        $units = Unit::get();
        $item_units = $item->itemUnit;
        $data['item_unit'] = ['contract_id' => $units->firstWhere('id', $item_units->contract_id)->name, 'subcontract_id' => $units->firstWhere('id', $item_units->subcontract_id)->name, 'build_id' => $units->firstWhere('id', $item_units->build_id)->name, 'supervisor_id' => $units->firstWhere('id', $item_units->supervisor_id)->name, 'servey_id' => $units->firstWhere('id', $item_units->servey_id)->name, 'design_id' => $units->firstWhere('id', $item_units->design_id)->name, 'trail_id' => $units->firstWhere('id', $item_units->trail_id)->name, 'safety_station_id' => $units->firstWhere('id', $item_units->safety_station_id)->name];

        return successJson($data);
    }

    public function update(ItemRequest $request, Item $project)
    {
        $project->update(['item_category_id' => $request->item_category_id, 'invest_id' => $request->invest_id, 'build_type_id' => $request->build_type_id, 'structural_type_id' => $request->structural_type_id, 'item_no' => $request->item_no, 'project_no' => $request->project_no, 'country' => $request->country, 'province' => $request->province, 'city' => $request->city, 'county' => $request->county, 'detail' => $request->detail, 'permit_no' => $request->permit_no, 'area' => $request->area, 'total_amount' => $request->total_amount, 'chargeman' => $request->chargeman, 'chargeman_tel' => $request->chargeman_tel, 'gps' => $request->gps, 'received_at' => $request->received_at, 'started_at' => $request->started_at, 'ended_at' => $request->ended_at, 'started_at' => $request->started_at, 'name' => $request->name,]);

        ItemUnit::where('item_id', $project->id)->update(['contract_id' => $request->contract_id, 'subcontract_id' => $request->subcontract_id, 'supervisor_id' => $request->supervisor_id, 'servey_id' => $request->servey_id, 'design_id' => $request->design_id, 'trail_id' => $request->trail_id, 'build_id' => $request->build_id, 'safety_station_id' => $request->safety_station_id,]);

        $items = Item::getItems();
        return successJson($items, '操作成功');
    }

    public function destroy(Request $request, Item $project)
    {
        // 删除项目
        $project->delete();
        // 删除项目关联
        $project->units()->sync($request->unit_ids);
        $items = Item::getItems();
        return successJson($items, '操作成功！');
    }

    public function findUnit(Request $request)
    {
        if ($request->has('id') && count($request->id) > 0) {
            $units = Unit::whereIn('id', $request->id)->select('id', 'name')->get();
            foreach ($units as $key => $unit) {
                $units[$key]['label'] = $unit['name'];
                unset($units[$key]['name']);
                $units[$key]['value'] = $unit['id'];
                unset($units[$key]['id']);
            }

            return successJson($units);
        }
    }

    public function form(Request $request)
    {
        $where = function($query) use ($request) {
            if ($request->has('name') && trim($request->name) != '') {
                $query->where('name', 'like', '%'.$request->name.'%');
            }
        };
        $pagesize = $request->has('pagesize') ? $request->pagesize: 10;
        $items = Item::where($where)->select('name', 'id')->orderBy('created_at', 'desc')->paginate($pagesize);
        return successJson($items);
    }
}
