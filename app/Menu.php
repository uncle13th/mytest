<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'icon',
        'url',
        'sort',
        'is_show'
    ];

    protected $casts = [
        'is_show' => 'boolean',
    ];

    // 获取子菜单
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort');
    }

    // 获取父菜单
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // 获取所有角色
    public function roles()
    {
        return $this->belongsToMany(\Spatie\Permission\Models\Role::class, 'role_menu');
    }

    // 递归获取所有子菜单
    public function getAllChildren()
    {
        return $this->children()->with('getAllChildren');
    }

    // 获取菜单的层级路径
    public function getPath()
    {
        $path = collect([$this]);
        $parent = $this->parent;

        while ($parent) {
            $path->prepend($parent);
            $parent = $parent->parent;
        }

        return $path;
    }
}
