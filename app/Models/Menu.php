<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'icon',
        'url',
        'sort',
        'is_show',
        'type'
    ];

    protected $casts = [
        'is_show' => 'boolean',
        'sort' => 'integer',
        'parent_id' => 'integer'
    ];

    /**
     * 获取子菜单
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort');
    }

    /**
     * 获取父菜单
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * 获取所有子菜单（递归）
     */
    public function getAllChildren()
    {
        return $this->children()->with(['children' => function($query) {
            $query->orderBy('sort')->with(['children' => function($query) {
                $query->orderBy('sort');
            }]);
        }]);
    }

    /**
     * 获取所有父菜单（递归）
     */
    public function getAllParents()
    {
        return $this->parent()->with('parent');
    }

    /**
     * 判断是否为顶级菜单
     */
    public function isTopLevel()
    {
        return $this->parent_id === 0;
    }

    /**
     * 判断是否为文件夹类型
     */
    public function isFolder()
    {
        return $this->type === 'folder';
    }

    /**
     * 判断是否为菜单类型
     */
    public function isMenu()
    {
        return $this->type === 'menu';
    }
}
