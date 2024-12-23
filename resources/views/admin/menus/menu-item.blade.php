<tr class="menu-item hover:bg-gray-50" data-id="{{ $menu->id }}" data-parent="{{ $menu->parent_id }}" data-sort="{{ $menu->sort }}">
    <td class="px-6 py-4 whitespace-nowrap w-1/6">
        <div class="flex items-center">
            @if($level > 0)
                <div class="mr-2 flex-shrink-0" style="width: {{ $level * 20 }}px"></div>
            @endif
            <span class="text-gray-400 flex-shrink-0">
                @if($menu->type === 'folder')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                @endif
            </span>
            <span class="ml-2 text-sm font-medium text-gray-900 truncate">{{ $menu->name }}</span>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap w-1/6">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
            {{ $menu->type === 'folder' ? '文件夹' : '菜单' }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap w-1/6 text-sm leading-5 text-gray-500">
        <div class="truncate">{{ $menu->url ?: '-' }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap w-1/6">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $menu->is_show ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $menu->is_show ? '显示' : '隐藏' }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap w-1/6 text-sm leading-5 text-gray-500">
        {{ $menu->sort }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap w-1/6 text-right text-sm leading-5 font-medium">
        <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">编辑</a>
        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="inline" onsubmit="return confirm('确定要删除这个菜单吗？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900">删除</button>
        </form>
    </td>
</tr>

@if($menu->children->count() > 0)
    @foreach($menu->children as $child)
        @include('admin.menus.menu-item', ['menu' => $child, 'level' => $level + 1])
    @endforeach
@endif
