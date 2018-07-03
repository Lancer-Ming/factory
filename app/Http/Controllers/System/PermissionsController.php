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
        $permissions = Permission::with([
            'children' => function($query) {
                $query->where('is_category', 1)->with([
                    'children' => function($query) {
                        $query->where('is_category', 1);
                    }
                ]);
            }
        ])->where(['is_category'=> 1, 'parent_id'=> 0])->get();
        return successJson($permissions);
    }


}
