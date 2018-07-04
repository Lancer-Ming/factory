<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Cache;

class HomeController extends Controller
{
    public function index()
    {


        // 首先获取所有的权限

//        $permissions = Cache::rememberForever('permissons', function() {
//            return Permission::with('roles')->get();
//        });
//
//        return $permissions;
//
//        // 用Gate::difine 对其权限每个都进行遍历记录
//        foreach($permissions as $permission) {
//            Gate::define($permission->name, function($user) use ($permission) {
//                return $user->hasPermission($permission);
//            });//Gate::define(arg1, arg2)  arg1是授权判断字段  arg2是返回的boolean 是否给授权
//        }

        return view('layouts.app', compact('permissions'));
    }
}
