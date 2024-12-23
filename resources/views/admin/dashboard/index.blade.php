@extends('admin.layouts.app')

@section('title', '仪表板')

@section('header', '仪表板')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- 管理员统计 -->
            <div class="bg-blue-50 p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                        <i class="fas fa-users-cog text-2xl text-white"></i>
                    </div>
                    <div class="ml-5">
                        <p class="mb-2 text-sm font-medium text-blue-600">管理员</p>
                        <p class="text-2xl font-semibold text-blue-900">{{ \App\Models\Admin::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- 角色统计 -->
            <div class="bg-green-50 p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                        <i class="fas fa-user-tag text-2xl text-white"></i>
                    </div>
                    <div class="ml-5">
                        <p class="mb-2 text-sm font-medium text-green-600">角色</p>
                        <p class="text-2xl font-semibold text-green-900">{{ Spatie\Permission\Models\Role::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- 权限统计 -->
            <div class="bg-purple-50 p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-500 bg-opacity-75">
                        <i class="fas fa-key text-2xl text-white"></i>
                    </div>
                    <div class="ml-5">
                        <p class="mb-2 text-sm font-medium text-purple-600">权限</p>
                        <p class="text-2xl font-semibold text-purple-900">{{ Spatie\Permission\Models\Permission::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 最近登录记录 -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">最近登录记录</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">管理员</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">登录时间</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">登录IP</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ auth()->guard('admin')->user()->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ now()->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ request()->ip() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
