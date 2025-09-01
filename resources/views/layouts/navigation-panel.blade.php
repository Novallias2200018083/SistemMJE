<nav class="w-64 bg-gray-800 text-white min-h-screen p-4">
    <div class="mb-6">
        <h2 class="font-bold text-xl">Menu Panel</h2>
        <span class="text-sm text-gray-400">{{ auth()->user()->name }}</span>
    </div>
    
    <ul>
        @if(auth()->user()->role === 'admin')
            <!-- Menu Admin -->
            <li class="mb-2">
                <a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.events.index') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.events.*') ? 'bg-gray-700' : '' }}">
                    Manajemen Event
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.attendance.index') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.attendance.*') ? 'bg-gray-700' : '' }}">
                    Presensi Pengunjung
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.lottery.index') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.lottery.*') ? 'bg-gray-700' : '' }}">
                    Pengundian
                </a>
            </li>
            {{-- Catatan: Rute untuk manajemen pengguna perlu dibuat --}}
            {{-- <li class="mb-2"><a href="#" class="block p-2 rounded hover:bg-gray-700">Manajemen Pengguna</a></li> --}}

        @elseif(auth()->user()->role === 'tenant')
            <!-- Menu Tenan -->
            <li class="mb-2">
                <a href="{{ route('tenant.dashboard') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('tenant.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard & Input Penjualan
                </a>
            </li>
        @endif

        <li class="mt-8 border-t border-gray-600 pt-4">
             <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="block p-2 rounded bg-red-600 text-center hover:bg-red-700">
                    Logout
                </a>
            </form>
        </li>
    </ul>
</nav>
