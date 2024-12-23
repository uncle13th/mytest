<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::where('guard_name', 'admin');
        
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
            
            $permissions = $query->orderBy('id', 'desc')->paginate(10);
            
            if ($permissions->isEmpty()) {
                return view('admin.permissions.index', [
                    'permissions' => collect([]),
                    'message' => '没有找到匹配的权限'
                ]);
            }
            
            return view('admin.permissions.index', compact('permissions'));
        }
        
        $permissions = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'admin'
        ]);

        return redirect()->route('permissions.index')->with('success', '权限创建成功');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', '权限更新成功');
    }

    public function destroy(Permission $permission)
    {
        // 检查是否有角色在使用这个权限
        if ($permission->roles()->count() > 0) {
            return back()->with('error', '该权限正在被角色使用，无法删除');
        }

        $permission->delete();
        return redirect()->route('permissions.index')->with('success', '权限删除成功');
    }
}
