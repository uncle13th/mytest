@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 text-3xl font-medium">新增菜单</h3>
        <a href="{{ route('admin.menus.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            返回列表
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div>
                    <label class="text-gray-700" for="name">菜单名称</label>
                    <input class="form-input w-full mt-2 rounded-md border-gray-300" 
                           type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700" for="parent_id">上级菜单</label>
                    <select class="form-select w-full mt-2 rounded-md border-gray-300" 
                            name="parent_id" 
                            id="parent_id">
                        <option value="0">顶级菜单</option>
                        @foreach($parentMenus as $parentMenu)
                            <option value="{{ $parentMenu->id }}" {{ old('parent_id') == $parentMenu->id ? 'selected' : '' }}>
                                {{ $parentMenu->name }}
                            </option>
                            @foreach($parentMenu->children as $childMenu)
                                <option value="{{ $childMenu->id }}" {{ old('parent_id') == $childMenu->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;&nbsp;&nbsp;└─ {{ $childMenu->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="url-field">
                    <label class="text-gray-700" for="url">URL</label>
                    <input class="form-input w-full mt-2 rounded-md border-gray-300" 
                           type="text" 
                           name="url" 
                           id="url" 
                           value="{{ old('url') }}">
                    @error('url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700" for="sort">排序</label>
                    <input class="form-input w-full mt-2 rounded-md border-gray-300" 
                           type="number" 
                           name="sort" 
                           id="sort" 
                           value="{{ old('sort', 0) }}" 
                           required>
                    <p class="mt-1 text-sm text-gray-500">数字越小越靠前</p>
                    @error('sort')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-700" for="is_show">显示状态</label>
                    <select class="form-select w-full mt-2 rounded-md border-gray-300" 
                            name="is_show" 
                            id="is_show" 
                            required>
                        <option value="1" {{ old('is_show', 1) == 1 ? 'selected' : '' }}>显示</option>
                        <option value="0" {{ old('is_show') === '0' ? 'selected' : '' }}>隐藏</option>
                    </select>
                    @error('is_show')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-gray-600">
                    保存
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlField = document.getElementById('url-field');
    
    urlField.style.display = 'block';
});
</script>
@endpush
@endsection
