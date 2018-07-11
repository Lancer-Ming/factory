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
        } else {
            $permissions = Auth::user()->roles->pluck('name')->contains('超级管理员')
                ? Permission::getAllPermissions()
                : Permission::$category;
        }

        return successJson($permissions);
    }

    public function store(PermissionRequest $request)
    {
        Permission::create($request->all());
        $permission = Permission::allPermissions();
        return successJson($permission);
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
        $permission->delete();
        $permission = Permission::allPermissions();
        return successJson($permission, '操作成功！');
    }
}
