<?php

namespace App\Http\Controllers\System;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PermissionsController extends Controller
{
    /**
     *  菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Auth::user()->roles->pluck('name')->contains('超级管理员')
            ? Permission::getAllPermissions()
            : Permission::$category;
        return successJson($permissions);
    }


}
