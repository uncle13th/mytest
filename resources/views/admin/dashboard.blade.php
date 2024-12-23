@extends('admin.layouts.app')

@section('title', '仪表板')

@section('header', '仪表板')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- 统计卡片 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                <i class="fas fa-users text-white text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">
                    总用户数
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    0
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                <i class="fas fa-chart-line text-white text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">
                    今日访问
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    0
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                <i class="fas fa-file-alt text-white text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">
                    总文章数
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    0
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-600 bg-opacity-75">
                <i class="fas fa-comment text-white text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">
                    总评论数
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    0
                </p>
            </div>
        </div>
    </div>
</div>

<!-- 系统信息 -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">系统信息</h3>
    </div>
    <div class="px-6 py-4">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Laravel 版本</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ app()->version() }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">PHP 版本</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ PHP_VERSION }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">服务器操作系统</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ php_uname('s') . ' ' . php_uname('r') }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">服务器软件</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $_SERVER['SERVER_SOFTWARE'] ?? '-' }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">数据库版本</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ DB::select('select version() as version')[0]->version }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">服务器时间</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ date('Y-m-d H:i:s') }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
