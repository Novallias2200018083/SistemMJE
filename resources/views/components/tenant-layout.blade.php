<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Tenan - {{ config('app.name', 'Laravel') }}</title>
    
     <link rel="icon" href="{{ asset('mjelogo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="relative min-h-screen">
        <!-- Memanggil sidebar yang posisinya fixed -->
        @include('layouts.tenant-navigation')

        <!-- Area Konten Utama -->
        <!-- Diberi margin kiri seukuran sidebar (w-64) pada layar desktop (md) -->
        <div class="md:ml-64">
            <!-- Header untuk Desktop (Sticky) -->
            <header class="hidden md:sticky md:top-0 md:z-10 md:flex bg-white py-4 px-8 justify-between items-center border-b border-gray-200 shadow-sm">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Tenan</h1>
                    <p class="text-sm text-gray-600 mt-1">Selamat datang, {{ Auth::user()->tenant->tenant_name ?? 'Tenan' }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Tombol Logout -->
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
                     <div class="bg-gray-800 p-2 rounded-lg">
                        <i class="fa-solid fa-store text-white text-sm"></i>
                    </div>
                    <h1 class="font-bold text-gray-800">Portal Tenan</h1>
                </div>
                <button id="sidebar-open-btn" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </header>

            <!-- Konten Halaman Slot -->
            <main class="p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('tenant-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('sidebar-open-btn');
            const closeBtn = document.getElementById('sidebar-close-btn');

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
        });
    </script>
</body>
</html>

