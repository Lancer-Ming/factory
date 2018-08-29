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
        // 项目名称筛选
        $itemWhere = function($query) use ($request) {
            if ($request->has('item_name') && trim($request->item_name != '')) {
                $query->where('name', 'like', '%'.$request->item_name.'%');
            }
        };

        // 施工单位筛选
        $buildUnitWhere = function($query) use ($request) {
            if ($request->has('unit_name') && trim($request->unit_name != '')) {
                $query->where('name', 'like', '%'.$request->unit_name.'%');
            }
        };

        // 扬尘sn、是否在线、有无报警筛选
        $dustWhere = function($query) use ($request) {
            if ($request->has('sn') && trim($request->sn != '')) {
                $query->where('sn', 'like', '%'.$request->sn.'%');
            }

            if ($request->has('is_online') && trim($request->is_online != '')) {
                $query->where('is_online', $request->is_online);
            }

            if ($request->has('cur_warn_count') && trim($request->cur_warn_count != '')) {
                $query->where('cur_warn_count', $request->cur_warn_count);
            }
        };

        // 关联模型条件查询
        $items =  Item::with(['dusts' => function($query) use ($dustWhere) {
            $query->select('item_id','sn','is_online','pre_warn_count','cur_warn_count')->where($dustWhere);
        }, 'buildUnit' => function($query) use ($buildUnitWhere) {
            $query->where($buildUnitWhere);
        }])->where($itemWhere)
            ->orderBy('created_at', 'desc')->select('id', 'name', 'item_no', 'permit_no')->paginate(30);

        // 过滤掉 buildUnit 或者 dusts 为空的item
        $items = $items->filter(function($value) {
            return $value->buildUnit->all() && $value->dusts->all();
        });

        foreach($items as $key => &$value) {
            $value['b_unit'] = $value->buildUnit->implode('name');
            $value['online_count'] = $value->dusts->sum('is_online');
            $value['pre_warning_count'] = $value->dusts->sum('pre_warn_count');
            $value['is_warning_count'] = $value->dusts->sum('cur_warn_count');
            unset($value->buildUnit);
        }


        return successJson($items);

    }
}
