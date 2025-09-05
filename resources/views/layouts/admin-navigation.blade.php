<!-- Overlay untuk sidebar mobile -->
<div id="admin-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

<aside id="admin-sidebar"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white min-h-screen flex flex-col shadow-lg border-r border-gray-200 transform -translate-x-full md:translate-x-0">
    <div class="p-4 flex items-center justify-between border-b bg-teal-600 text-white">
        <div class="flex items-center space-x-3">
            <div class="bg-white/30 p-2 rounded-lg">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="sidebar-text">
                <h1 class="font-bold text-lg">Admin Panel</h1>
                <p class="text-sm">Jogja Expo 2025</p>
            </div>
        </div>
        <button id="admin-sidebar-close-btn" class="md:hidden text-white hover:text-gray-200">
            <i class="fas fa-times fa-lg"></i>
        </button>
    </div>

    <div class="p-4 border-b">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 rounded-full bg-teal-200 text-teal-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="sidebar-text">
                <p class="font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-500">Administrator</p>
            </div>
        </div>
    </div>

    <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}"
            class="menu-item flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-table-columns fa-fw mr-3"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="menu-item flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-teal-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-users fa-fw mr-3"></i>
            <span class="sidebar-text">Manajemen Pengguna</span>
        </a>

        <a href="{{ route('admin.tenan.index') }}"
            class="menu-item flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{ request()->routeIs('admin.tenan.*') ? 'bg-teal-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-store fa-fw mr-3"></i>
            <span class="sidebar-text">Manajemen Tenan</span>
        </a>

        <a href="{{ route('admin.events.index') }}"
            class="menu-item flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{ request()->routeIs('admin.events.*') ? 'bg-teal-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-calendar-days fa-fw mr-3"></i>
            <span class="sidebar-text">Manajemen Acara</span>
        </a>

        <a href="{{ route('admin.newslatter.index') }}"
            class="menu-item flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{ request()->routeIs('admin.newslatter.*') ? 'bg-teal-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-newspaper fa-fw mr-3"></i>
            <span class="sidebar-text">Manajemen Berita</span>
        </a>

        <a href="{{ route('admin.attendance.index') }}"
            class="menu-item flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{ request()->routeIs('admin.attendance.*') ? 'bg-teal-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-user-check fa-fw mr-3"></i>
            <span class="sidebar-text">Kelola Kehadiran</span>
        </a>

        <a href="{{ route('admin.lottery.index') }}"
            class="menu-item flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{ request()->routeIs('admin.lottery.*') ? 'bg-teal-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fa-solid fa-gift fa-fw mr-3"></i>
            <span class="sidebar-text">Pengundian</span>
        </a>
    </nav>

    <div class="p-4 border-t mt-auto">
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="w-full text-center block py-2 border border-gray-200 rounded-lg text-gray-600 font-semibold hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors duration-200">
                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>
                <span class="sidebar-text">Keluar</span>
            </a>
        </form>
    </div>
</aside>
