<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理后台') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- 添加 Font Awesome 图标 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- 侧边栏 -->
        <div class="bg-gray-800 text-white w-64 px-6 py-4 flex flex-col">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">管理后台</h1>
            </div>
            <nav class="flex-1">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-home mr-2"></i>仪表板
                </a>
                
                <div class="mt-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        系统管理
                    </h3>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('admin.menus.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.menus.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                            <i class="fas fa-bars mr-2"></i>菜单管理
                        </a>
                        <a href="{{ route('admin.admins.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.admins.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                            <i class="fas fa-users-cog mr-2"></i>管理员管理
                        </a>
                        <a href="{{ route('admin.roles.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                            <i class="fas fa-user-tag mr-2"></i>角色管理
                        </a>
                        <a href="{{ route('admin.permissions.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.permissions.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                            <i class="fas fa-key mr-2"></i>权限管理
                        </a>
                    </div>
                </div>
            </nav>
            <div class="mt-auto pb-4">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->guard('admin')->user()->name }}" alt="用户头像">
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ auth()->guard('admin')->user()->name }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-gray-700 transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>退出登录
                    </button>
                </form>
            </div>
        </div>

        <!-- 主要内容区 -->
        <div class="flex-1">
            <!-- 顶部导航栏 -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-semibold text-gray-800">
                        @yield('header', '仪表板')
                    </h2>
                </div>
            </header>

            <!-- 页面内容 -->
            <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- 添加 Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
