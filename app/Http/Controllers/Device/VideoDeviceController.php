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
        $where = function($query) use ($request) {
            if ($request->has('d_name') && trim($request->d_name != '')) {
                $query->where('d_name', 'like', '%'.$request->d_name.'%');
            }
        };

        $pagesize = $request->has('pagesize') ? $request->pagesize: 10;
        $videoDevices = Device::where($where)->with('ys_id')->paginate($pagesize);

        return successJson($videoDevices);
    }

    public function store(Request $request)
    {
        $ysData = $request->only('appkey', 'secret', 'access_token', 'username', 'password', 'phone', 'expiretime');
        $ys = Ys::create($ysData);

        $videoDeviceData = $request->only('d_name', 'serial', 'channel_no','validate_code','install_at', 'chargeman','chargeman_tel','ezopen','hls_address','created_at','updated_at','item_id');
        $videoDeviceData['ys_id'] = $ys->id;
        Device::create($videoDeviceData);

        $videoDevices = Device::with('ys')->get();

        return successJson($videoDevices);
    }
}
