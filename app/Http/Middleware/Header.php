<?php

namespace App\Http\Middleware;

use Closure;
use Gate;
use App\Models\Permission;

class Header
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

        // 拿到所有的组装好了的权限菜单，和当前用户有的进行比较，没有的unset掉
        $sort_permissions = Permission::getAllPermissions();

        foreach($sort_permissions as $key=>$sort_permission) {
            // 如果有用户拥有的一级权限菜单
            if (Gate::denies($sort_permission['name'])) {
                unset($sort_permissions[$key]);
                continue;
            } else {
                foreach($sort_permission['children'] as $k=>$children) {
                    if (Gate::denies($children['name'])) {
                        unset($sort_permissions[$key]['children'][$k]);
                    }
                }
            }
        }

        Permission::$category = $sort_permissions;

        return $next($request);
    }
}
