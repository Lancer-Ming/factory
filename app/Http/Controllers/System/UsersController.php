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
        $users = User::with('roles')->paginate(10);
        return successJson($users);
    }

    public function store(UserRequest $request)
    {
        $userData = $request->only(['username', 'realname', 'sex', 'email', 'password']);
        $user = User::create($userData);

        $user->roles()->attach($request->role_id);

        return successJson('', '', 201);
    }

    public function edit(User $user)
    {
        $user->roles = $user->roles;
        return successJson($user);
    }

    public function update(UserRequest $request, User $user)
    {
        if ($request->password == '') {
            $userData = $request->only(['username', 'realname', 'sex', 'email']);
        } else {
            $userData = $request->only(['username', 'realname', 'sex', 'email', 'password']);
        }
        
        $user->update($userData);

        //获取先前的role_id
        $role_ids = $user->roles->pluck('id');
        // 删除以前中间表的role_id
        $user->roles()->detach($role_ids);

        // 增加新的role_id
        $user->roles()->attach($request->role_id);

        $newUser = User::with('roles')->find($user->id);
    
        return successJson($newUser, '操作成功！');
    }

    public function destroy()
    {
        
    }

    public function getRoles()
    {
        $roles = Role::all();
        $result = [];
        foreach($roles as $role) {
            $result[] = ['value' => $role->id, 'label' => $role->name];
        }
        return successJson($result, '');
    }
}
