<?php

namespace App\Http\Controllers\System;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::OrderBy('created_at', 'desc')->paginate(10);
        return successJson($roles);
    }

    public function store(Request $request)
    {
        $role = Role::create($request->name);
        return successJson($role, '操作成功');
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->name);
        return successJson($role, '操作成功');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        // 删除一个和删除多个都一样

        Role::destroy($id);

        // 重新获取列表
        $roles = Role::OrderBy('created_at', 'desc')->paginate(10);
        return successJson($roles, '删除成功！');

    }
}
