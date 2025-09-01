<x-admin-layout>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="subheader">Overview & statistik</x-slot>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
            <p class="text-gray-500">Selamat datang di panel admin Muhammadiyah Expo 2025</p>
        </div>
    </div>

    <div class="mb-6 flex border-b">
        <a href="{{ route('admin.dashboard', ['day' => 'all']) }}" class="px-4 py-2 font-semibold border-b-2 {{ $selectedDay == 'all' ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Semua Hari</a>
        <a href="{{ route('admin.dashboard', ['day' => 1]) }}" class="px-4 py-2 font-semibold border-b-2 {{ $selectedDay == 1 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 1</a>
        <a href="{{ route('admin.dashboard', ['day' => 2]) }}" class="px-4 py-2 font-semibold border-b-2 {{ $selectedDay == 2 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 2</a>
        <a href="{{ route('admin.dashboard', ['day' => 3]) }}" class="px-4 py-2 font-semibold border-b-2 {{ $selectedDay == 3 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 3</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Total Peserta</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalAttendees, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Terdaftar di sistem</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Total Kehadiran @if($selectedDay !== 'all') (Hari Ke-{{$selectedDay}}) @endif</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalAttendance, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Presensi di event</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Total Penjualan @if($selectedDay !== 'all') (Hari Ke-{{$selectedDay}}) @endif</p>
            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Revenue total</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Tingkat Kehadiran @if($selectedDay !== 'all') (Hari Ke-{{$selectedDay}}) @endif</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($attendanceRate, 1) }}%</p>
            <p class="text-xs text-gray-400">Dari total peserta</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="font-bold text-lg mb-4">Kehadiran Harian</h3>
            <ul class="space-y-3">
                @foreach($dailyAttendance as $dayLabel => $count)
                <li class="flex justify-between items-center">
                    <div>
                        <span class="font-semibold">{{ $dayLabel }}</span>
                        @if($dayLabel == "Hari " . $eventDayNow) <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full ml-2">Berlangsung</span> @endif
                    </div>
                    <span class="font-semibold text-gray-700">{{ $count }} / {{ $totalAttendees }}</span>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('admin.attendance.index') }}" class="text-teal-600 font-semibold text-sm mt-4 inline-block">Kelola Presensi <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="font-bold text-lg mb-4">Penjualan Harian</h3>
            <ul class="space-y-3">
                @foreach($dailySales as $dayLabel => $sale)
                <li class="flex justify-between items-center">
                    <div>
                        <span class="font-semibold">{{ $dayLabel }}</span>
                        @if($dayLabel == "Hari " . $eventDayNow) <p class="text-xs text-blue-500">Berlangsung</p> @endif
                    </div>
                    <span class="font-semibold text-teal-600">Rp {{ number_format($sale, 0, ',', '.') }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
        <h3 class="font-bold text-lg mb-4">Tenan Terlaris @if($selectedDay !== 'all') (Hari Ke-{{$selectedDay}}) @else (Semua Hari) @endif</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($topTenants as $category => $tenants)
            <div>
                <h4 class="font-semibold capitalize mb-3 border-b pb-2">{{ Str::title(str_replace('_', ' ', $category)) }}</h4>
                <ul class="space-y-3">
                    @forelse($tenants as $index => $tenant)
                        @if($tenant->total_sales > 0)
                        <li class="flex justify-between items-center text-sm">
                            <span class="truncate pr-2">
                                <span class="bg-gray-200 rounded-full w-5 h-5 inline-flex items-center justify-center mr-2 font-bold">{{ $index + 1 }}</span>
                                {{ $tenant->tenant_name }}
                            </span>
                            <span class="font-semibold text-teal-600 whitespace-nowrap">Rp {{ number_format($tenant->total_sales, 0, ',', '.') }}</span>
                        </li>
                        @endif
                    @empty
                    <li class="text-sm text-gray-400">Belum ada data penjualan.</li>
                    @endforelse

                    @if($tenants->where('total_sales', '>', 0)->isEmpty())
                        <li class="text-sm text-gray-400">Belum ada data penjualan.</li>
                    @endif
                </ul>
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="font-bold text-lg mb-4">
                Event Hari Ini 
                @if($eventDayNow > 0)
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full ml-2">Hari Ke-{{ $eventDayNow }} Sedang Berlangsung</span>
                @endif
            </h3>
            <div class="space-y-4">
                @forelse($todaysEvents as $event)
                <div class="border-b pb-3 last:border-b-0">
                    <div class="flex justify-between items-start">
                        <p class="font-semibold">{{ $event->title }}</p>
                        <span class="text-xs font-semibold bg-gray-100 px-2 py-1 rounded-full">Hari {{ $event->day }}</span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">{{ $event->description }}</p>
                    <p class="text-sm text-gray-500 mt-2"><i class="fa-regular fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</p>
                </div>
                @empty
                <p class="text-gray-500">Tidak ada event yang dijadwalkan untuk hari ini.</p>
                @endforelse
            </div>
            <a href="{{ route('admin.events.index') }}" class="text-teal-600 font-semibold text-sm mt-4 inline-block">Kelola Semua Event <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="font-bold text-lg mb-4">Menu Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.users.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-users text-2xl text-teal-600"></i>
                    <p class="mt-2 font-semibold text-sm">Kelola Pengguna</p>
                </a>
                <a href="{{ route('admin.attendance.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-user-check text-2xl text-teal-600"></i>
                    <p class="mt-2 font-semibold text-sm">Input Presensi</p>
                </a>
                <a href="{{ route('admin.lottery.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-gift text-2xl text-teal-600"></i>
                    <p class="mt-2 font-semibold text-sm">Undian</p>
                </a>
                <a href="{{ route('admin.events.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-calendar-days text-2xl text-teal-600"></i>
                    <p class="mt-2 font-semibold text-sm">Kelola Event</p>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>