<?php

namespace App\Http\Controllers\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Ys;

class VideoDeviceController extends Controller
{
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('d_name') && trim($request->d_name != '')) {
                $query->where('d_name', 'like', '%' . $request->d_name . '%');
            }
        };

        $pagesize = $request->has('pagesize') ? $request->pagesize : 10;
        $videoDevices = Device::where('item_id', $request->item_id)->where($where)->with('ys')->paginate($pagesize);

        return successJson($videoDevices);
    }

    public function store(Request $request)
    {
        $ysData = $request->only('appkey', 'secret', 'access_token', 'username', 'password', 'phone', 'expiretime');
        $ys = Ys::where(['appkey' => $ysData['appkey'], 'secret' => $ysData['secret']])->first();
        if ($ys) {
            $ys->update(['access_token' => $ys->access_token, 'username' => $request->username ?: $ys->username, 'password' => $request->password ?: $ys->password, 'phone' => $request->phone ?: $ys->phone, 'expiretime' => $request->expiretime ?: $ys->expiretime,]);
        } else {
            $ys = Ys::create($ysData);
        }

        $videoDeviceData = $request->only('d_name', 'serial', 'channel_no', 'validate_code', 'install_at', 'chargeman', 'chargeman_tel', 'hls', 'hlsHd','rtmp','rtmpHd','created_at', 'updated_at', 'item_id');
        $videoDeviceData['ys_id'] = $ys->id;

        $videoDeviceData['channel_no'] = (int)$videoDeviceData['channel_no'];
        Device::create($videoDeviceData);

        $pagesize = $request->has('pagesize') ? $request->pagesize : 10;
        $videoDevices = Device::where('item_id', $request->item_id)->with('ys')->paginate($pagesize);
        return successJson($videoDevices, '操作成功！');
    }

    public function destroy(Request $request, Device $video_device)
    {
        $video_device->delete();

        $pagesize = $request->data['pagesize'] ? $request->pagesize : 10;
        $videoDevices = Device::where('item_id', $request->data['item_id'])->with('ys')->paginate($pagesize);
        return successJson($videoDevices, '操作成功！');
    }

    public function address(Request $request)
    {
        $datas = $request->data['data'];
        foreach($datas as $data) {
            Device::where('serial', $data['deviceSerial'])->update(['hls'=> $data['hls'], 'hlsHd'=> $data['hlsHd'], 'rtmp'=> $data['rtmp'], 'rtmpHd' => $data['rtmpHd']]);
        }
        $pagesize = $request->has('pagesize') ? $request->pagesize : 10;
        $videoDevices = Device::where('item_id', $request->data['item_id'])->with('ys')->paginate($pagesize);
        return successJson($videoDevices, '操作成功！');
    }
}
