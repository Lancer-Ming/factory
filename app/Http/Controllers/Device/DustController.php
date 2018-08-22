<?php

namespace App\Http\Controllers\Device;

use App\Models\Dust;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DustController extends Controller
{
    public function index()
    {
        $where = function($query) use ($request) {
            // 备案编号
            if ($request->has('sn') && trim($request->sn) != '') {
                $query->where('sn', 'like', '%'.(int) $request->sn.'%');
            }

            // 监测站名称
            if ($request->has('item_name') && trim($request->item_name) != '') {
                $item_id = Item::where('name', 'like', '%'.$request->item_name.'%')->first()->id;
                $query->where('item_id', $item_id);
            }

            // 检测点名称
            if ($request->has('monitor_place_name') && trim($request->monitor_place_name) != '') {
                $query->where('monitor_place_name', 'like', '%'.$request->monitor_place_name.'%');
            }

            // 是否在线
            if ($request->has('is_online') && trim($request->is_online) != '') {
                $query->where('is_online', (int) $request->is_online);
            }
        };

        $pagesize = $request->has('pagesize') ? $request->pagesize : 30;
        $dusts = Dust::where($where)->orderBy('created_at', 'asc')->paginate($pagesize);

        return successJson($dusts);
    }

    

    protected function returnDust($pagesize=30) {

    }
}
