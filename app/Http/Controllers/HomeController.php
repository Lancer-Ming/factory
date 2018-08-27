<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Cache;

use App\Hardware\Entrance;

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
        return view('test');
    }

    public function gateway()
    {
        $client_id = 10000;
        $message = "##0239QN=20180821142509000;ST=39;CN=2011;PW=123456;MN=690000D5800028F889221AC0;Flag=4;CP=&&DataTime=20180821142509;a34004-Rtd=0.0;a34002-Rtd=0.0;a34001-Rtd=0.0;LA-Rtd=0.0;a01001-Rtd=0.0;a01002-Rtd=0.0;a01006-Rtd=0.0;a01007-Rtd=0.0;a01008-Rtd=0&&E541";

        return Entrance::Dust($message)->store($client_id);
        return view('gateway123');
    }
}
