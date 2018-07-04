<?php

namespace App\Http\Controllers\System;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    /**
     *  菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::$category;
        return successJson($permissions);
    }


}
