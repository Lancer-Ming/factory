<?php

namespace App\Http\Controllers\System;

use App\Http\Requests\PermissionRequest;
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
    public function index(Request $request)
    {
        if ($request->has('is_category')) {
            $permissions = Permission::allPermissions();
            $simplePermissions = Permission::where('is_category', 1)->get()->toArray();
            $simplePermissions = array_merge($simplePermissions, [['id'=> 0,'label'=>'顶级菜单']]);
            return successJson(compact('permissions','simplePermissions'));
        } else {
            $permissions = Auth::user()->roles->pluck('name')->contains('超级管理员')
                ? Permission::getAllPermissions()
                : Permission::$category;
        }

        $permissions = $permissions->values()->toArray();

        forEach($permissions as $key => &$children) {
            $children['children'] = array_values($children['children']);
            forEach($children['children'] as &$child) {
                if (array_key_exists('children', $child)) {
                    $child['children'] = array_values($child['children']);
                    foreach ($child['children'] as &$c) {
                        if (array_key_exists('children', $c)) {
                            $c['children'] = array_values($c['children']);
                        }
                    }
                }
            }
        }

        return successJson($permissions);
    }

    public function store(PermissionRequest $request)
    {
        Permission::create($request->all());
        $permission = Permission::allPermissions();
        return successJson($permission, '操作成功！');
    }

    public function edit(Permission $permission)
    {
        return successJson($permission);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());
        $permission = Permission::allPermissions();
        return successJson($permission, '操作成功！');
    }

    public function destroy(Permission $permission)
    {
        // 获取所有的children的id
        $childIds = $permission->getChildPermissionIds($permission);
        // 加上当前的permission的id
        $childIds[] = $permission->id;
        Permission::destroy($childIds);

        $permission = Permission::allPermissions();
        return successJson($permission, '操作成功！');
    }

    /**
     * 排序
     */
    public function sort(Request $request) {
        $sort = json_decode($request->sort);
        //一级
        foreach ($sort as $key => $value) {
            Permission::sort($value->id, 0, $key);

            //二级
            if (isset($value->children)) {
                foreach ($value->children as $key_children => $children) {
                    Permission::sort($children->id, $value->id, $key_children);

                    //三级
                    if(isset($children->children)) {
                        foreach($children->children as $key_c=> $c) {
                            Permission::sort($c->id, $children->id, $key_c);
                        }

                        // 四级
                        if(isset($c->children)) {
                            foreach($c->children as $key_cc => $cc) {
                                Permission::sort($cc->id, $c->id, $key_cc);
                            }
                        }
                    }
                }
            }
        }

        $permission = Permission::allPermissions();
        return successJson($permission, '操作成功！');
    }
}
