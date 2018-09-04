<?php

namespace App\Http\Controllers\Ys;

use App\Models\Ys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YsUsersController extends Controller
{
    public function accessToken(Request $request)
    {
        $appkey = $request->appKey;
        $secret = $request->appSecret;
        $ys = Ys::where(['appkey'=> $appkey, 'secret'=> $secret])->first();

        if (!isset($ys)) {
            return failJson(['status' => 0]);
        }

        if(empty($ys->access_token) || floor($ys->expiretime/1000) <= time()) {
            return successJson(['status' => 0, 'accessToken' => $ys->access_token]);
        } else {
            return successJson(['status' => 1, 'accessToken' => $ys->access_token, 'expireTime'=> $ys->expiretime]);
        }
    }
}
