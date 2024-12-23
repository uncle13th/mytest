@extends('admin.layouts.app')

@section('title', '编辑角色')

@section('header', '编辑角色')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">编辑角色</h3>
        </div>
        
        <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="p-4">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">角色名称</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name', $role->name) }}" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">权限列表</label>
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200 max-h-60 overflow-y-auto">
                    @foreach($permissions as $permission)
                        <label class="inline-flex items-center mr-6 mb-2">
                            <input type="checkbox" 
                                   name="permissions[]" 
                                   value="{{ $permission->name }}"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   {{ in_array($permission->name, $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('permissions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">菜单权限</label>
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200 max-h-60 overflow-y-auto">
                    @foreach($menus as $menu)
                        <div class="mb-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" 
                                       name="menus[]" 
                                       value="{{ $menu->id }}"
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       {{ in_array($menu->id, $role->menus->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">{{ $menu->name }}</span>
                            </label>
                            @if($menu->children->count() > 0)
                                <div class="ml-6 mt-2">
                                    @foreach($menu->children as $child)
                                        <label class="inline-flex items-center mr-6 mb-2">
                                            <input type="checkbox" 
                                                   name="menus[]" 
                                                   value="{{ $child->id }}"
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                   {{ in_array($child->id, $role->menus->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-700">{{ $child->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @error('menus')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.roles.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-2">
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
