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

// 管理后台登录路由
Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login')->middleware('guest:admin');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login.post')->middleware('guest:admin');

// 管理后台认证路由
Route::middleware(['auth:admin'])->group(function () {
    Route::post('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
    
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('admins', AdminController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('menus', MenuController::class);
        Route::post('menus/order', [MenuController::class, 'updateOrder'])->name('menus.order');
    });
});
