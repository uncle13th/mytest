<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // 获取状态筛选参数，默认为显示
        $status = $request->get('status', 'show');

        // 获取所有菜单数据
        $query = Menu::where('parent_id', 0)->orderBy('sort');
        
        // 如果不是显示全部，则只显示可见菜单
        if ($status !== 'all') {
            $query->where('is_show', true);
        }

        $menus = $query->with(['children' => function ($query) use ($status) {
            $query->orderBy('sort');
            if ($status !== 'all') {
                $query->where('is_show', true);
            }
        }])->get();

        return view('admin.menus.index', compact('menus', 'status'));
    }

    /**
     * 递归筛选子菜单
     */
    private function filterMenuChildren($children, $status)
    {
        return $children->when($status !== 'all', function ($collection) use ($status) {
                // 筛选符合状态条件的菜单
                return $collection->filter(function ($menu) use ($status) {
                    return $menu->is_show === ($status === 'show');
                });
            })
            ->map(function ($menu) use ($status) {
                // 递归处理下一级子菜单
                if ($menu->children && $menu->children->count() > 0) {
                    $menu->children = $this->filterMenuChildren($menu->children, $status);
                }
                return $menu;
            });
    }

    public function create()
    {
        // 获取所有菜单用于选择父级菜单
        $parentMenus = Menu::where('parent_id', 0)
            ->with(['children' => function ($query) {
                $query->orderBy('sort');
            }])
            ->orderBy('sort')
            ->get();

        return view('admin.menus.create', compact('parentMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'required|integer',
            'url' => 'nullable|max:255',
            'sort' => 'required|integer',
            'is_show' => 'required|boolean',
        ]);

        // 如果是文件夹类型，清空 URL
        if ($request->type === 'folder') {
            $request->merge(['url' => null]);
        }

        Menu::create($request->all());
        return redirect()->route('admin.menus.index')->with('success', '菜单创建成功');
    }

    public function edit(Menu $menu)
    {
        // 获取所有可选的父级菜单（排除自己及其子菜单）
        $parentMenus = Menu::where('parent_id', 0)
            ->where('id', '!=', $menu->id)
            ->with(['children' => function ($query) use ($menu) {
                $query->where('id', '!=', $menu->id)
                    ->orderBy('sort');
            }])
            ->orderBy('sort')
            ->get();

        return view('admin.menus.edit', compact('menu', 'parentMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'required|integer',
            'url' => 'nullable|max:255',
            'sort' => 'required|integer',
            'is_show' => 'required|boolean',
        ]);

        // 检查是否将菜单设置为其子菜单的子菜单
        if ($this->isChildMenu($menu, $request->parent_id)) {
            return back()->with('error', '不能将菜单设置为其子菜单的子菜单');
        }

        // 准备要更新的数据
        $data = $request->only(['name', 'parent_id', 'url', 'sort', 'is_show']);

        $menu->update($data);
        return redirect()->route('admin.menus.index')->with('success', '菜单更新成功');
    }

    public function destroy(Menu $menu)
    {
        // 检查是否有子菜单
        if ($menu->children()->exists()) {
            return back()->with('error', '请先删除子菜单');
        }

        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', '菜单删除成功');
    }

    public function updateOrder(Request $request)
    {
        $items = $request->input('items', []);
        
        foreach ($items as $item) {
            Menu::where('id', $item['id'])->update([
                'parent_id' => $item['parent_id'],
                'sort' => $item['sort']
            ]);
        }

        return response()->json(['message' => '排序更新成功']);
    }

    /**
     * 检查是否是子菜单
     */
    private function isChildMenu($menu, $parentId)
    {
        if ($parentId == 0) {
            return false;
        }

        $parent = Menu::find($parentId);
        while ($parent) {
            if ($parent->id === $menu->id) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }
}
