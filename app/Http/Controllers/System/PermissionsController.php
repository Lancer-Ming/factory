<?php

namespace App\Http\Controllers\System;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    /**
     *  获取一级菜单
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $permissions = Permission::with([
//            'children' => function($query) {
//                $query->where('is_category', 1)->with([
//                    'children' => function($query) {
//                        $query->where('is_category', 1);
//                    }
//                ]);
//            }
//        ])->where(['is_category'=> 1, 'parent_id'=> 0])->get();
        $permissions = Permission::where('parent_id', 0)->get();
        return $permissions;
    }

    public function getSideBars(Permission $permission)
    {

        $results = $permission->children()->with([
            'children' => function($query) {
                $query->where('is_category', 1);
            }
        ])->get();
        return successJson($results);
    }

}
