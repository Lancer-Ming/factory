<?php

namespace App\Http\Controllers\Device;

use App\Http\Requests\DustRequest;
use App\Models\Dust;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DustController extends Controller
{
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            // 备案编号
            if ($request->has('sn') && trim($request->sn) != '') {
                $query->where('sn', 'like', '%' . (int)$request->sn . '%');
            }

            // 监测站名称
            if ($request->has('item_name') && trim($request->item_name) != '') {
                $item_id = Item::where('name', 'like', '%' . $request->item_name . '%')->first()->id;
                $query->where('item_id', $item_id);
            }

            // 检测点名称
            if ($request->has('monitor_place_name') && trim($request->monitor_place_name) != '') {
                $query->where('monitor_place_name', 'like', '%' . $request->monitor_place_name . '%');
            }

            // 是否在线
            if ($request->has('is_online') && trim($request->is_online) != '') {
                $query->where('is_online', (int)$request->is_online);
            }
        };

        $pagesize = $request->has('pagesize') ? $request->pagesize : 30;
        // 获取该用户拥有的项目id
        $item_ids = User::prossessItemId();
        $dusts = Dust::where($where)->whereIn('item_id', $item_ids)->orderBy('created_at', 'asc')->paginate($pagesize);

        return successJson($dusts);
    }

    public function store(DustRequest $request)
    {
        if (!User::authorite($dust)) {
            return failJson('请勿尝试更改请求地址', 401);
        }

        Dust::create($request->all());
        return successJson($this->returnDust(), '操作成功！');
    }

    public function edit(Dust $dust)
    {
        if (!User::authorite($dust)) {
            return failJson('请勿尝试更改请求地址', 401);
        }
        return successJson($dust);
    }

    public function update(DustRequest $request, Dust $dust)
    {
        if (!User::authorite($dust)) {
            return failJson('请勿尝试更改请求地址', 401);
        }
        $dust->update($request->all());
        return successJson($this->returnDust(), '操作成功！');

    }

    public function destroy(Request $request)
    {
        if (!User::authorite($dust)) {
            return failJson('请勿尝试更改请求地址', 401);
        }
        Dust::destroy($request->id);
        return successJson($this->returnDust(), '操作成功！');

    }

    protected function returnDust($pagesize = 30)
    {
        return Dust::orderBy('created_at', 'asc')->paginate($pagesize);
    }
}
