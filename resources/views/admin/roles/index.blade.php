@extends('admin.layouts.app')

@section('title', '角色管理')

@section('header', '角色管理')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
        <div class="flex-1">
            <form action="{{ route('admin.roles.index') }}" method="GET" class="flex items-center">
                <label for="search" class="mr-2 text-sm font-medium text-gray-700">角色名称</label>
                <div class="relative" style="width: 200px;">
                    <input type="text" 
                           id="search"
                           name="search" 
                           value="{{ request('search') }}" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           style="height: 36px;">
                </div>
                <button type="submit" 
                        class="ml-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        style="height: 40px;">
                    <i class="fas fa-search mr-2"></i>搜索
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.roles.index') }}" 
                       class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       style="height: 40px;">
                        清除搜索
                    </a>
                @endif
            </form>
        </div>
        <div class="ml-4">
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-plus mr-2"></i>添加角色
            </a>
        </div>
    </div>
    
    @if(session('message'))
        <div class="bg-yellow-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">角色名称</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">权限</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">创建时间</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                </tr>
            </thead>
            @unless($roles->isEmpty())
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($roles as $role)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @foreach($role->permissions as $permission)
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full mr-1">
                                {{ $permission->name }}
                            </span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->created_at }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit"></i> 编辑
                        </a>
                        @if($role->name !== 'super-admin')
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('确定要删除此角色吗？')">
                                <i class="fas fa-trash"></i> 删除
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            @else
            <tbody>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        暂无数据
                    </td>
                </tr>
            </tbody>
            @endunless
        </table>
    </div>

    @if($roles->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $roles->links() }}
    </div>
    @endif
</div>
@endsection
