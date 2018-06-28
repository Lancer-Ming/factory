<?php

namespace App\Http\Controllers\System;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     *  获取一级菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::where('parent_id', 0)->get();
        return successJson($permissions);
    }

}
