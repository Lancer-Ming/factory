<?php

namespace App\Http\Controllers\Ys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YsController extends Controller
{
    public function accessToken(Request $request)
    {
        $url = $request->url;
        $data = $request->data;
        $result = curl_post($url, $data);
        return $result;
    }

    public function videoDeviceAdd(Request $request)
    {
        $result = curl_post($request->url, $request->data);
        return $result;
    }
}
