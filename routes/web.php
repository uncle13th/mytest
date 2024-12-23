<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\MenuController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // 登录相关路由
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // 管理员管理
    Route::resource('admins', AdminController::class)->names([
        'index' => 'admins.index',
        'create' => 'admins.create',
        'store' => 'admins.store',
        'show' => 'admins.show',
        'edit' => 'admins.edit',
        'update' => 'admins.update',
        'destroy' => 'admins.destroy',
    ]);
    
    // 角色管理
    Route::resource('roles', RoleController::class)->names([
        'index' => 'roles.index',
        'create' => 'roles.create',
        'store' => 'roles.store',
        'show' => 'roles.show',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy',
    ]);
    
    // 权限管理
    Route::resource('permissions', PermissionController::class)->names([
        'index' => 'permissions.index',
        'create' => 'permissions.create',
        'store' => 'permissions.store',
        'show' => 'permissions.show',
        'edit' => 'permissions.edit',
        'update' => 'permissions.update',
        'destroy' => 'permissions.destroy',
    ]);
    
    // 菜单管理
    Route::resource('menus', MenuController::class)->names([
        'index' => 'menus.index',
        'create' => 'menus.create',
        'store' => 'menus.store',
        'show' => 'menus.show',
        'edit' => 'menus.edit',
        'update' => 'menus.update',
        'destroy' => 'menus.destroy',
    ]);
    Route::post('menus/update-order', [MenuController::class, 'updateOrder'])->name('menus.updateOrder');
});
