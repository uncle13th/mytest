@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 text-3xl font-medium">菜单管理</h3>
        <a href="{{ route('admin.menus.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            新增菜单
        </a>
    </div>

    <div class="mt-8">
        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                    名称
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                    类型
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                    URL
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                    显示
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                    排序
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/6">
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
        </div>
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
        group: 'menu',
        animation: 150,
        ghostClass: 'bg-blue-100',
        dragClass: 'bg-blue-50',
        handle: '.menu-item',
        onStart: function (evt) {
            document.body.style.cursor = 'grabbing';
        },
        onEnd: function (evt) {
            document.body.style.cursor = 'default';
            updateMenuOrder();
        }
    };
    
    // 初始化主列表的拖拽
    new Sortable(menuList, sortableOptions);
    
    // 初始化子菜单的拖拽
    menuItems.forEach(item => {
        new Sortable(item, sortableOptions);
    });
    
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white transform transition-transform duration-300 translate-y-0`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.transform = 'translateY(150%)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    function updateMenuOrder() {
        const items = [];
        let order = 0;
        
        function processMenuItem(item, parentId = 0) {
            items.push({
                id: item.dataset.id,
                parent_id: parentId,
                sort: order++
            });
            
            const childrenContainer = item.querySelector('.menu-children');
            if (childrenContainer) {
                const children = childrenContainer.querySelectorAll(':scope > .menu-item');
                children.forEach(child => processMenuItem(child, item.dataset.id));
            }
        }
        
        menuList.querySelectorAll(':scope > .menu-item').forEach(item => {
            processMenuItem(item);
        });
        
        fetch('{{ route("admin.menus.updateOrder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ items })
        })
        .then(response => response.json())
        .then(data => {
            showToast(data.message || '菜单排序更新成功');
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('更新排序失败', 'error');
        });
    }
});
</script>
@endpush
@endsection
