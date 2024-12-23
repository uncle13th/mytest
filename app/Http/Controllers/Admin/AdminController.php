<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Admin::with('roles');
        
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }
        
        $admins = $query->paginate(10);
        
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:admins',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'array'
        ]);

        $admin = Admin::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'password' => Hash::make($validated['password'])
        ]);

        if (isset($validated['roles'])) {
            $admin->assignRole($validated['roles']);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', '管理员创建成功！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'array'
        ]);

        $admin->username = $validated['username'];
        $admin->name = $validated['name'];
        
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        
        $admin->save();

        $admin->syncRoles($validated['roles'] ?? []);

        return redirect()->route('admin.admins.index')
            ->with('success', '管理员更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', '不能删除当前登录的管理员！');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', '管理员删除成功！');
    }
}
