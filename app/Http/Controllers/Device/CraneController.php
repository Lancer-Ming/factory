<?php

namespace App\Http\Controllers\Device;

use App\Http\Requests\CraneRequest;
use App\Models\BlackBox;
use App\Models\Crane;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CraneController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = $request->has('pagesize') ? $request->pagesize: 30;

        $crane_where = function($query) use ($request) {
            // 备案编号
            if ($request->has('record_no') && trim($request->record_no) != '') {
                $query->where('record_no', 'like', '%'.$request->record_no.'%');
            }

            // 项目名称
            if ($request->has('item_name') && trim($request->item_name) != '') {
                $item_id = Item::where('name', 'like', '%'.$request->item_name.'%')->first()->id;
                $query->where('item_id', $item_id);
            }

            // 产权单位
            if ($request->has('right_name') && trim($request->right_name) != '') {
                $right_id = Unit::where('name', 'like', '%'.$request->right_name.'%')->first()->id;
                $query->where('right_id', $right_id);
            }

            // 是否在线
            if ($request->has('is_online') && trim($request->is_online) != '') {
                $query->where('is_online', (int) $request->is_online);
            }
        };

        // 黑匣子 SN
        if ($request->has('sn') && trim($request->sn) != '') {
            $blackbox_where = function($query) use ($request) {
                $query->where('sn', 'like', '%'.$request->sn.'%');
            };
            $crane_id = BlackBox::where($blackbox_where)->first()->crane_id;
            $cranes = Crane::where($crane_where)->where('id', $crane_id)->orderBy('created_at', 'desc')->with('items',  'blackBoxes')->paginate($pagesize);
        } else {
            $cranes = Crane::where($crane_where)->orderBy('created_at', 'desc')->with('items', 'blackBoxes')->paginate($pagesize);
        }



        return successJson($cranes);
    }

    public function store(CraneRequest $request)
    {
        // 将 crane 表添加数据
        $crane = Crane::create($request->all());

        //给 黑匣子表添加数据
        $request->merge(['crane_id'=> $crane->id]);
        BlackBox::create($request->all());

        return successJson($this->returnCrane($request->pagesize));
    }

    public function edit(Crane $crane)
    {
        $crane->fill(['blackBoxes' => $crane->blackBoxes]);

        return successJson($crane);
    }

    public function update(Request $request, Crane $crane)
    {
        $crane->update($request->all());

        $crane->blackBoxes()->update($request->only(['install_unit_id', 'crane_id', 'sn', 'GPRS', 'validity_month', 'model', 'paid_at', 'installed_at',
            'function_config', 'identify']));

        return successJson($this->returnCrane($request->pagesize));
    }

    public function destroy(Request $request)
    {
        Crane::destroy($request->id);

        BlackBox::whereIn('crane_id', $request->id)->delete();

        return successJson($this->returnCrane($request->pagesize));
    }

    protected function returnCrane($pagesize=10)
    {
        return Crane::with('blackBoxes')->paginate($pagesize);
    }
}
