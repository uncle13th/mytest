<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Admin;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 重置角色和权限缓存
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 创建权限
        Permission::create(['name' => 'manage admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage permissions', 'guard_name' => 'admin']);

        // 创建角色并分配权限
        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // 为ID为1的管理员分配超级管理员角色
        $admin = Admin::find(1);
        if ($admin) {
            $admin->assignRole('super-admin');
        }
    }
}
