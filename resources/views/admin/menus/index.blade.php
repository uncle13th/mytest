@extends('admin.layouts.app')

@section('title', '菜单管理')

@section('header', '菜单管理')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
        <div class="flex-1">
            <!-- 这里可以添加搜索功能 -->
        </div>
        <div class="ml-4">
            <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-plus mr-2"></i>新增菜单
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-2/5">
                        名称
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/5">
                        URL
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/10">
                        显示
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/10">
                        排序
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/10">
                        操作
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="menu-list">
                @foreach($menus as $menu)
                    @include('admin.menus.menu-item', ['menu' => $menu, 'level' => 0])
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuList = document.getElementById('menu-list');
    const menuItems = document.querySelectorAll('.menu-children');
    
    // 通用的Sortable配置
    const sortableOptions = {
        animation: 150,
        fallbackOnBody: true,
        swapThreshold: 0.65,
        onEnd: function(evt) {
            const item = evt.item;
            const newParentId = evt.to.dataset.parentId || 0;
            const prevItem = item.previousElementSibling;
            const nextItem = item.nextElementSibling;
            
            let sort = 0;
            if (!prevItem && !nextItem) {
                sort = 0;
            } else if (!prevItem) {
                sort = parseInt(nextItem.dataset.sort) - 1;
            } else if (!nextItem) {
                sort = parseInt(prevItem.dataset.sort) + 1;
            } else {
                sort = (parseInt(prevItem.dataset.sort) + parseInt(nextItem.dataset.sort)) / 2;
            }

            // 发送Ajax请求更新菜单项的排序
            fetch(`/admin/menus/${item.dataset.id}/sort`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    parent_id: newParentId,
                    sort: sort
                })
            }).then(response => {
                if (!response.ok) {
                    throw new Error('排序更新失败');
                }
                return response.json();
            }).then(data => {
                console.log('排序更新成功:', data);
            }).catch(error => {
                console.error('Error:', error);
                // 可以添加用户提示
            });
        }
    };

    // 为顶级菜单列表创建 Sortable 实例
    new Sortable(menuList, {
        ...sortableOptions,
        group: 'menu'
    });

    // 为每个子菜单列表创建 Sortable 实例
    menuItems.forEach(menuItem => {
        new Sortable(menuItem, {
            ...sortableOptions,
            group: 'menu'
        });
    });
});
</script>
@endpush

@endsection
