<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //如果该用户是超级管理员，直接拥有任何权限，跳过
        $role_names = \Auth::user()->roles->pluck('name');
        if($role_names->contains('超级管理员') || Route::currentRouteName() == 'system.permission.index') {
            return $next($request);
        }

        // 首先获取所有的权限
        $permissions = Cache::rememberForever('permissons', function() {
            return Permission::with('roles')->get();
        });

        // 用Gate::difine 对其权限每个都进行遍历记录
        foreach($permissions as $permission) {
            Gate::define($permission->name, function($user) use ($permission) {
                return $user->hasPermission($permission);
            });//Gate::define(arg1, arg2)  arg1是授权判断字段  arg2是返回的boolean 是否给授权
        }

        // 先确定该路由是否需要权限控制
        $permission_names = $permissions->pluck('name')->all();
        if (!in_array(Route::currentRouteName(), $permission_names)) {
            return $next($request);
        }

        if (Gate::denies(Route::currentRouteName())) {
            if ($request->ajax()) {
                return failJson('您无权限操作，有需要请和管理员联系');
            }
        }

        return $next($request);

        
    }
}
