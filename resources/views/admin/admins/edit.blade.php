@extends('admin.layouts.app')

@section('title', '编辑管理员')

@section('header', '编辑管理员')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">编辑管理员</h3>
        </div>
        
        <form action="{{ route('admin.admins.update', $admin) }}" method="POST" class="p-4">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">用户名</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('username', $admin->username) }}" required>
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">密码</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="确认密码">
                <p class="mt-1 text-sm text-gray-500">留空表示不修改密码</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">姓名</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name', $admin->name) }}" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">角色</label>
                <div class="mt-2 space-y-2">
                    @foreach($roles as $role)
                    <div class="flex items-center">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            {{ in_array($role->name, old('roles', $admin->roles->pluck('name')->toArray())) ? 'checked' : '' }}>
                        <label class="ml-2 text-sm text-gray-700">{{ $role->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('roles')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.admins.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-2">
                    取消
                </a>
                <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    保存
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
