<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /** 与角色多对多关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission(Permission $permission)
    {
        // 查询拥有该权限的角色
        $permission_roles = $permission->roles;

        // 查询当前的user拥有的角色
        $user_roles = \Auth::user()->roles;

        // 查询user和权限拥有的角色是否有交集
        return $permission_roles->intersect($user_roles)->count() > 0;
    }
}
