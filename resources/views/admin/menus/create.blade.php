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
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold leading-6 text-gray-900">新增菜单</h3>
        </div>
        
        <form action="{{ route('admin.menus.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">菜单名称</label>
                <input type="text" name="name" id="name" class="mt-2 block w-full rounded-md border-0 px-4 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ old('name') }}" required>
                @error('name')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label for="parent_id" class="block text-sm font-medium leading-6 text-gray-900">父级菜单</label>
                <select name="parent_id" id="parent_id" class="mt-2 block w-full rounded-md border-0 px-4 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="url" class="block text-sm font-medium leading-6 text-gray-900">URL</label>
                <input type="text" name="url" id="url" class="mt-2 block w-full rounded-md border-0 px-4 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ old('url') }}" required>
                @error('url')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="sort" class="block text-sm font-medium leading-6 text-gray-900">排序</label>
                <input type="number" name="sort" id="sort" class="mt-2 block w-full rounded-md border-0 px-4 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ old('sort', 0) }}" required>
                @error('sort')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium leading-6 text-gray-900">显示状态</label>
                <div class="mt-2 space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="1" class="form-radio text-indigo-600 h-4 w-4" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">显示</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="0" class="form-radio text-indigo-600 h-4 w-4" {{ old('status') === '0' ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">隐藏</span>
                    </label>
                </div>
                @error('status')
                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.menus.index') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">取消</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
