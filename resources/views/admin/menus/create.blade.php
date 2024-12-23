@extends('admin.layouts.app')

@section('title', '新增菜单')

@section('breadcrumb')
    <h2 class="text-xl font-semibold text-gray-800">
        <a href="{{ route('admin.menus.index') }}" class="hover:text-indigo-600">菜单管理</a>
        <span class="text-gray-400 mx-2">&gt;</span>
        <span class="text-gray-600">新增菜单</span>
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">添加新菜单</h3>
        </div>
        
        <form action="{{ route('admin.menus.store') }}" method="POST" class="p-4">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">名称</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name') }}" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="parent_id" class="block text-sm font-medium text-gray-700">父级菜单</label>
                <select name="parent_id" id="parent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="0">顶级菜单</option>
                    @foreach($parentMenus as $menu)
                        <option value="{{ $menu->id }}" {{ old('parent_id') == $menu->id ? 'selected' : '' }}>
                            {{ $menu->name }}
                        </option>
                        @if($menu->children)
                            @foreach($menu->children as $child)
                                <option value="{{ $child->id }}" {{ old('parent_id') == $child->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $child->name }}
                                </option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                <input type="text" name="url" id="url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('url') }}">
                @error('url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="sort" class="block text-sm font-medium text-gray-700">排序</label>
                <input type="number" name="sort" id="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('sort', 0) }}" required>
                @error('sort')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">显示状态</label>
                <div class="mt-2 space-y-2">
                    <div class="flex items-center">
                        <input type="radio" name="is_show" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" {{ old('is_show', '1') == '1' ? 'checked' : '' }}>
                        <label class="ml-2 text-sm text-gray-700">显示</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="is_show" value="0" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" {{ old('is_show') == '0' ? 'checked' : '' }}>
                        <label class="ml-2 text-sm text-gray-700">隐藏</label>
                    </div>
                </div>
                @error('is_show')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.menus.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-2">
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
