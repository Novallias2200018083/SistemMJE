<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Transisi untuk sidebar dan konten utama */
        #admin-sidebar, .content-wrapper {
            transition: all 0.3s ease-in-out;
        }
        /* Style saat sidebar di-collapse (desktop) */
        body.sidebar-collapsed #admin-sidebar {
            width: 80px; /* Lebar saat collapsed */
        }
        body.sidebar-collapsed #admin-sidebar .sidebar-text {
            display: none;
        }
        body.sidebar-collapsed #admin-sidebar .menu-item {
            justify-content: center;
        }
        /* Menyesuaikan margin konten utama saat sidebar di-collapse */
        body.sidebar-collapsed .content-wrapper {
            margin-left: 80px;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="relative min-h-screen">
        <!-- Memanggil sidebar admin yang posisinya fixed -->
        @include('layouts.admin-navigation')

        <!-- Area Konten Utama -->
        <div class="content-wrapper md:ml-64">
            <!-- Header untuk Desktop (Sticky) -->
            <header class="hidden md:sticky md:top-0 md:z-10 md:flex bg-white py-4 px-8 justify-between items-center border-b border-gray-200 shadow-sm">
                <div class="flex items-center space-x-4">
                    <!-- Tombol untuk collapse/expand sidebar di desktop -->
                    <button id="sidebar-toggle-desktop" class="text-gray-500 hover:text-gray-800 focus:outline-none">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $header ?? 'Admin Panel' }}</h1>
                        <p class="text-sm text-gray-600 mt-1">{{ $subheader ?? 'Selamat datang, Admin' }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200 flex items-center text-sm shadow-sm">
                            <i class="fa-solid fa-arrow-right-from-bracket fa-fw mr-2"></i>
                            Logout
                        </a>
                    </form>
                </div>
            </header>

            <!-- Header untuk Mobile (Sticky) -->
            <header class="sticky top-0 z-10 md:hidden bg-white p-4 flex justify-between items-center shadow-md">
                <div class="flex items-center space-x-2">
                     <div class="bg-teal-600 p-2 rounded-lg">
                        <i class="fa-solid fa-shield-halved text-white text-sm"></i>
                    </div>
                    <h1 class="font-bold text-gray-800">Admin Panel</h1>
                </div>
                <button id="admin-sidebar-open-btn" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Logika untuk Flyout Menu Mobile ---
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            const openBtn = document.getElementById('admin-sidebar-open-btn');
            const closeBtn = document.getElementById('admin-sidebar-close-btn');

            const openSidebar = () => {
                if (sidebar) sidebar.classList.remove('-translate-x-full');
                if (overlay) overlay.classList.remove('hidden');
            };

            const closeSidebar = () => {
                if (sidebar) sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
            };

            if (openBtn) openBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);

            // --- Logika untuk Collapse/Expand Sidebar Desktop ---
            const desktopToggleButton = document.getElementById('sidebar-toggle-desktop');
            const body = document.body;

            const toggleDesktopSidebar = () => {
                body.classList.toggle('sidebar-collapsed');
                const isCollapsed = body.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarState', isCollapsed ? 'collapsed' : 'open');
            };

            if (desktopToggleButton) {
                desktopToggleButton.addEventListener('click', toggleDesktopSidebar);
            }

            // Memuat status sidebar dari localStorage saat halaman dibuka (hanya untuk desktop)
            if (window.innerWidth >= 768) {
                const savedState = localStorage.getItem('sidebarState');
                if (savedState === 'collapsed') {
                    body.classList.add('sidebar-collapsed');
                }
            }
        });
    </script>
</body>
</html>

