<?php

namespace App\Http\Controllers\System;

use App\Models\Permission;
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
        Role::create(['name' => $request->name]);
        $roles = Role::OrderBy('created_at', 'desc')->paginate(10);
        return successJson($roles, '操作成功');
    }

    public function update(Request $request, Role $role)
    {
        $role->update(['name'=> $request->name]);
        return successJson($role, '操作成功');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        // 删除一个和删除多个都一样

        Role::destroy($id);
        \DB::table('permission_role')->whereIn('role_id', $id)->delete();

        // 重新获取列表
        $roles = Role::OrderBy('created_at', 'desc')->paginate(10);
        return successJson($roles, '删除成功！');
    }

    public function editPermission(Role $role)
    {
        $data = [];
        $data['permissions'] = Permission::allPermissions();
        $data['own_permissions_id'] = $role->permissions->pluck('id');
        return successJson($data);
    }

    public function updatePermission(Request $request, Role $role)
    {
        $permission_id = $request->permission_id;
        $role->permissions()->sync($permission_id);
        return successJson('','操作成功！');
    }
}
