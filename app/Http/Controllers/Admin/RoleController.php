<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Menu;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::where('guard_name', 'admin')->with(['permissions', 'menus']);
        
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
            
            $roles = $query->orderBy('id', 'desc')->paginate(10);
            
            if ($roles->isEmpty()) {
                return view('admin.roles.index', [
                    'roles' => collect([]),
                    'message' => '没有找到匹配的角色'
                ]);
            }
            
            return view('admin.roles.index', compact('roles'));
        }
        
        $roles = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        $menus = Menu::where('parent_id', 0)->with('children')->orderBy('sort')->get();
        return view('admin.roles.create', compact('permissions', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'admin'
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        if ($request->has('menus')) {
            $role->menus()->sync($request->menus);
        }

        return redirect()->route('roles.index')->with('success', '角色创建成功');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        $menus = Menu::where('parent_id', 0)->with('children')->orderBy('sort')->get();
        return view('admin.roles.edit', compact('role', 'permissions', 'menus'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'super-admin') {
            return back()->with('error', '超级管理员角色不能修改');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        if ($request->has('menus')) {
            $role->menus()->sync($request->menus);
        } else {
            $role->menus()->sync([]);
        }

        return redirect()->route('roles.index')->with('success', '角色更新成功');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'super-admin') {
            return back()->with('error', '超级管理员角色不能删除');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', '角色删除成功');
    }
}
