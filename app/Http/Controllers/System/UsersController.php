<?php

namespace App\Http\Controllers\System;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'items')->orderBy('created_at', 'desc')->paginate(config('home.pagesize'));
        return successJson($users);
    }

    public function store(UserRequest $request)
    {
        $password = createRandomPwd();
        $user = User::create(['username' => $request->username, 'realname' => $request->realname, 'sex' => $request->sex, 'email' => $request->email, 'password' => bcrypt($password)]);

        $user->roles()->attach($request->role_id);

        // 重新查users列表
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(10);
        $data['users'] = $users;
        $data['userInfo'] = ['username' => $request->username, 'password' => $password];
        return successJson($data, '操作成功！', 201);
    }

    public function edit(User $user)
    {
        $user->roles = $user->roles;
        return successJson($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update(['username' => $request->username, 'realname' => $request->realname, 'sex' => $request->sex, 'email' => $request->email, 'password' => $request->password ? bcrypt($request->password) : $user->password]);

        //获取先前的role_id
        $role_ids = $user->roles->pluck('id');
        // 删除以前中间表的role_id
        $user->roles()->detach($role_ids);

        // 增加新的role_id
        $user->roles()->attach($request->role_id);

        $newUser = User::with('roles')->find($user->id);

        return successJson($newUser, '操作成功！');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        // 删除多个
        if (is_array($id)) {
            User::destroy($id);
            \DB::table('role_user')->whereIn('user_id', $id)->delete();
        } else {
            $user = User::find($id);
            $user->delete();
            //获取先前的role_id
            $role_ids = $user->roles->pluck('id');
            // 删除以前中间表的role_id
            $user->roles()->detach($role_ids);
        }

        // 重新查users列表
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(10);
        return successJson($users, '删除成功！');
    }

    public function getRoles()
    {
        $roles = Role::all();
        $result = [];
        foreach ($roles as $role) {
            $result[] = ['value' => $role->id, 'label' => $role->name];
        }
        return successJson($result, '');
    }

    public function item(Request $request, User $user)
    {
        $user->items()->sync($request->itemId);

        $pagesize = $request->has('pagesize') ? $request->pagesize : config('home.pagesize');
        $users = User::with('roles', 'items')->orderBy('created_at', 'desc')->paginate($pagesize);
        return successJson($users, '操作成功！');
    }

    public function getItem(User $user)
    {
        $items = $user->items;
        return successJson($items);
    }

    public function userInfo()
    {
        return successJson(\Auth::user());
    }
}
