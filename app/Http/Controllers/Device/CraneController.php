<?php

namespace App\Http\Controllers\Device;

use App\Http\Requests\CraneRequest;
use App\Models\BlackBox;
use App\Models\Crane;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CraneController extends Controller
{
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
