<?php

namespace App\Http\Controllers\Ys;

use App\Models\Ys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YsController extends Controller
{
    public function post(Request $request)
    {
        $params = $request->data;
        if ($this->accessTokenIsValid()) {
            $ys = Ys::where('access_token', $request->accessToken)->first();
            $data = [
                'appKey' => $ys->appkey,
                'secret' => $ys->secret
            ];
            $response = curl_post('https://open.ys7.com/api/lapp/token/get', $data);
            $access_token = $response['data']['accessToken'];
            $params['accessToken'] = $access_token;
        }
        $result = curl_post($request->url, $params);
        return $result;
    }

    private function accessTokenIsValid($access_token)
    {
        $ys = Ys::where('access_token', $access_token)->first();
        if (empty($ys->access_token) || floor($ys->expiretime / 1000) <= time()) {
            return false;
        } else {
            return true;
        }
    }
}
