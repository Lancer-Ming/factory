<?php

namespace App\Http\Controllers\System;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with([
            'roles' => function($query) {
                $query->select('name');
            }
        ])->paginate(10);
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
        $userData = $request->only(['username', 'realname', 'sex', 'email', 'password']);
        $user->update($userData);

        //获取先前的role_id
        $role_ids = $user->roles->pluck('id');
        // 删除以前中间表的role_id
        $user->roles()->detach($role_ids);

        // 增加新的role_id
        $user->roles()->attach($request->role_id);
        return successJson('', '', 204);
    }

    public function destroy()
    {
        
    }
}
