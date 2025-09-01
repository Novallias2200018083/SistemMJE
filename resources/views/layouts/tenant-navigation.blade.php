<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

<!-- Sidebar Navigation - now fixed on all screens -->
<aside id="tenant-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white h-screen flex flex-col shadow-lg border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 z-30">
    
    <!-- Logo and Close Button for Mobile -->
    <div class="p-4 flex items-center justify-between border-b">
        <div class="flex items-center space-x-3">
            <div class="bg-gray-800 p-3 rounded-lg">
                <i class="fa-solid fa-store text-white"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg text-gray-800">Portal Tenan</h1>
                <p class="text-sm text-gray-500">Muhammadiyah Expo</p>
            </div>
        </div>
        <!-- Mobile-only Close Button -->
        <button id="sidebar-close-btn" class="md:hidden text-gray-500 hover:text-gray-800">
            <i class="fas fa-times fa-lg"></i>
        </button>
    </div>

    <!-- User Info -->
    <div class="p-4 border-b">
        <p class="font-bold text-gray-800 truncate">{{ Auth::user()->tenant->tenant_name }}</p>
        <p class="text-sm text-gray-500">{{ Auth::user()->name }}</p>
        <span class="mt-2 inline-block text-xs font-semibold bg-orange-100 text-orange-800 px-2 py-1 rounded-full capitalize">
            {{ Str::title(str_replace('_', ' ', Auth::user()->tenant->category)) }}
        </span>
    </div>

    <!-- Navigation Links (Scrollable) -->
    <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
        <a href="{{ route('tenant.dashboard') }}"
           class="flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{
               request()->routeIs('tenant.dashboard')
               ? 'bg-gray-800 text-white shadow'
               : 'text-gray-600 hover:bg-gray-100'
           }}">
            <i class="fa-solid fa-chart-pie fa-fw mr-3"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('tenant.sales.index') }}"
           class="flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{
               request()->routeIs(['tenant.sales.index', 'tenant.sales.create_detail'])
               ? 'bg-gray-800 text-white shadow'
               : 'text-gray-600 hover:bg-gray-100'
           }}">
            <i class="fa-solid fa-dollar-sign fa-fw mr-3"></i>
            <span>Input Penjualan</span>
        </a>
        
        <a href="{{ route('tenant.sales.history') }}"
           class="flex items-center px-4 py-2.5 rounded-lg font-semibold transition-colors duration-200 {{
               request()->routeIs('tenant.sales.history')
               ? 'bg-gray-800 text-white shadow'
               : 'text-gray-600 hover:bg-gray-100'
           }}">
            <i class="fa-solid fa-clock-rotate-left fa-fw mr-3"></i>
            <span>Riwayat Penjualan</span>
        </a>
    </nav>

    <!-- Footer / Logout -->
    <div class="p-4 border-t mt-auto">
        <div class="flex items-center space-x-2">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
            </span>
            <p class="text-sm text-gray-600">Online</p>
        </div>
        <p class="text-xs text-gray-400 truncate mt-1">{{ Auth::user()->email }}</p>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="w-full text-center block py-2 border border-gray-200 rounded-lg text-gray-600 font-semibold hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors duration-200">
                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>
                <span>Keluar</span>
            </a>
        </form>
    </div>
</aside>

