<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Cache;

class HomeController extends Controller
{
    public function index()
    {
        return view('index', compact('permissions'));
    }

    public function api()
    {
        return view('api');
    }
    public function test()
    {
        $url = 'https://open.ys7.com/api/lapp/token/get';
        $postdata = ['appKey'=> '456a2fecfbc449cbae2433b79714ea37', 'appSecret'=> 'e633406f986aca6a5a60e6e01a4abb20'];
        curl_post($url, $postdata);
    }
}
