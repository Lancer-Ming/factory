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
        curl_post($url, $data);
    }
}
