<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('children.children')->get();

        return view('layouts.app', compact('permissions'));
    }
}
