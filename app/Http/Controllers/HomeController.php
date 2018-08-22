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

        dd($dust->formatData());
        return view('gateway123');
    }
}
