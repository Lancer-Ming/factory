<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    static $category = [];

    private $children_ids = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**不包括操作的
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAllPermissions()
    {
        return self::with([
            'children' => function($query) {
                $query->where('is_category', 1)->with([
                    'children' => function($query) {
                        $query->where('is_category', 1);
                    }
                ]);
            }
        ])->where(['is_category'=> 1, 'parent_id'=> 0])->get();
    }

    /**
     * 包括操作
     */
    public static function allPermissions()
    {
        return self::with([
            'children' => function($query) {
                $query->order()->with([
                    'children' => function($query) {
                        $query->order()->with([
                            'children' => function($query) {
                                $query->order();
                            }
                        ]);
                    }
                ]);
            }
        ])->where(['parent_id' => 0])->get();
    }

    /** 排序
     * @param $id
     * @param $parent_id
     * @param $sort
     */
    public static function sort($id, $parent_id, $sort)
    {
        $permission = self::find($id);
        $permission->sort = $sort;
        $permission->parent_id = $parent_id;
        $permission->save();
    }

    public function getChildPermissionIds($permission)
    {
        if (isset($permission->children) && $permission->children->count() > 0) {
            foreach($permission->children as $value) {
                $this->children_ids[] = $value->id;
                $this->getChildPermissionIds($value);
            }
        }

        return $this->children_ids;

    }

    public function scopeOrder($query)
    {
        $query->orderBy('sort', 'asc')->orderBy('created_at', 'desc');
    }
}
