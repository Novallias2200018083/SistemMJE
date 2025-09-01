<x-admin-layout>
    <x-slot name="header">Manajemen Pengguna</x-slot>
    <x-slot name="subheader">Kelola data peserta</x-slot>

    <!-- Header & Tombol Aksi -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
            <p class="text-gray-500">Kelola data peserta yang terdaftar di event</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700"><i class="fa-solid fa-plus mr-2"></i>Tambah Peserta</a>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm"><p class="text-gray-500 text-sm">Total Peserta</p><p class="text-3xl font-bold text-gray-800">{{ number_format($totalAttendees) }}</p></div>
        <div class="bg-white p-6 rounded-lg shadow-sm"><p class="text-gray-500 text-sm">Hadir Hari 1</p><p class="text-3xl font-bold text-gray-800">{{ $dailyAttendance[1] ?? 0 }}</p></div>
        <div class="bg-white p-6 rounded-lg shadow-sm"><p class="text-gray-500 text-sm">Hadir Hari 2</p><p class="text-3xl font-bold text-gray-800">{{ $dailyAttendance[2] ?? 0 }}</p></div>
        <div class="bg-white p-6 rounded-lg shadow-sm"><p class="text-gray-500 text-sm">Hadir Hari 3</p><p class="text-3xl font-bold text-gray-800">{{ $dailyAttendance[3] ?? 0 }}</p></div>
    </div>

    <!-- Konten Utama dengan Tabs -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <!-- Navigasi Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-6" id="tabs">
                <a href="#daftar" class="tab-link py-2 px-1 border-b-2 border-teal-500 font-semibold text-teal-600">Daftar Peserta</a>
                <a href="#analisis" class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Analisis</a>
                <a href="#laporan" class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Laporan</a>
            </nav>
        </div>
        
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Konten Tab -->
        <div id="tab-contents">
            <!-- Tab: Daftar Peserta -->
            <div id="daftar" class="tab-content">
                <!-- Filter & Pencarian -->
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end p-4 border rounded-lg mb-6">
                        <div><label for="search" class="text-sm font-medium">Pencarian</label><input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama, token, HP" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm"></div>
                        <div><label for="regency" class="text-sm font-medium">Kabupaten</label><select name="regency" id="regency" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm"><option value="Semua">Semua Kabupaten</option>@foreach($regencies as $regency)<option value="{{ $regency }}" {{ request('regency') == $regency ? 'selected' : '' }}>{{ $regency }}</option>@endforeach</select></div>
                        <div><label for="attendance_status" class="text-sm font-medium">Kehadiran</label><select name="attendance_status" id="attendance_status" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm"><option value="">Semua Status</option><option value="Hadir" {{ request('attendance_status') == 'Hadir' ? 'selected' : '' }}>Sudah Hadir</option><option value="Tidak Hadir" {{ request('attendance_status') == 'Tidak Hadir' ? 'selected' : '' }}>Belum Hadir</option></select></div>
                        <button type="submit" class="bg-gray-800 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-700 h-10">Filter</button>
                    </div>
                </form>

                <!-- Daftar Peserta -->
                <div class="space-y-4">
                    @forelse($attendees as $attendee)
                    @php
                        $hadir1 = $attendee->attendances->contains('day', 1);
                        $hadir2 = $attendee->attendances->contains('day', 2);
                        $hadir3 = $attendee->attendances->contains('day', 3);
                        $totalHadir = $attendee->attendances->count();
                    @endphp
                    <div class="bg-white border rounded-lg p-4 flex flex-wrap items-center justify-between gap-4 hover:bg-gray-50">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                                {{ substr($attendee->name, 0, 1) }}{{ str_contains($attendee->name, ' ') ? substr(explode(' ', $attendee->name)[1], 0, 1) : '' }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $attendee->name }} <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">{{ $attendee->token }}</span></p>
                                <div class="flex flex-wrap items-center gap-x-4 text-sm text-gray-500 mt-1">
                                    <span><i class="fa-solid fa-location-dot mr-1"></i>{{ $attendee->regency }}</span>
                                    <span><i class="fa-solid fa-phone mr-1"></i>{{ $attendee->phone_number }}</span>
                                    <span><i class="fa-solid fa-calendar-day mr-1"></i>{{ $attendee->age }} tahun</span>
                                </div>
                                <div class="flex items-center space-x-3 text-sm mt-2">
                                    <span class="font-semibold">Kehadiran:</span>
                                    <span class="{{ $hadir1 ? 'text-green-600' : 'text-red-500' }}"><i class="fa-solid {{ $hadir1 ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>H1</span>
                                    <span class="{{ $hadir2 ? 'text-green-600' : 'text-red-500' }}"><i class="fa-solid {{ $hadir2 ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>H2</span>
                                    <span class="{{ $hadir3 ? 'text-green-600' : 'text-red-500' }}"><i class="fa-solid {{ $hadir3 ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>H3</span>
                                    <span class="text-xs font-bold bg-gray-800 text-white px-2 py-1 rounded-full">{{ $totalHadir }}/3 hari</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-2 flex-shrink-0">
                            <a href="{{ route('admin.users.edit', $attendee->id) }}" class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 text-sm hover:bg-gray-100"><i class="fa-solid fa-pencil mr-2"></i>Edit</a>
                            <form action="{{ route('admin.users.destroy', $attendee->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 border border-red-300 rounded-lg font-semibold text-red-700 text-sm hover:bg-red-50"><i class="fa-solid fa-trash mr-2"></i>Hapus</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-500"><i class="fa-solid fa-user-slash fa-3x mb-4"></i><p>Tidak ada data peserta yang cocok dengan filter Anda.</p></div>
                    @endforelse
                </div>
                <div class="mt-6">{{ $attendees->appends(request()->query())->links() }}</div>
            </div>

            <!-- Tab: Analisis -->
            <div id="analisis" class="tab-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Distribusi per Kabupaten -->
                    <div>
                        <h3 class="font-bold text-lg mb-4">Distribusi per Kabupaten</h3>
                        <div class="space-y-3">
                            @foreach($regencyDistribution as $dist)
                            <div class="flex items-center">
                                <span class="w-1/3 text-gray-600">{{ $dist->regency }}</span>
                                <div class="w-2/3 bg-gray-200 rounded-full h-4">
                                    <div class="bg-teal-500 h-4 rounded-full text-xs text-white text-right pr-2" style="width: {{ $totalAttendees > 0 ? ($dist->total / $totalAttendees) * 100 : 0 }}%"></div>
                                </div>
                                <span class="w-16 text-right font-semibold">{{ $dist->total }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Distribusi Usia -->
                    <div>
                        <h3 class="font-bold text-lg mb-4">Distribusi Usia</h3>
                        <div class="space-y-3">
                            @foreach($ageDistribution as $dist)
                            <div class="flex items-center">
                                <span class="w-1/3 text-gray-600">{{ $dist->age_group }}</span>
                                <div class="w-2/3 bg-gray-200 rounded-full h-4">
                                    <div class="bg-blue-500 h-4 rounded-full text-xs text-white text-right pr-2" style="width: {{ $totalAttendees > 0 ? ($dist->total / $totalAttendees) * 100 : 0 }}%"></div>
                                </div>
                                <span class="w-16 text-right font-semibold">{{ $dist->total }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab: Laporan -->
            <div id="laporan" class="tab-content hidden">
                 <h3 class="font-bold text-lg mb-4">Laporan & Export</h3>
                 <p class="text-gray-500 mb-6">Download berbagai laporan data peserta dalam format CSV/Excel.</p>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('admin.export.users.complete') }}" class="block p-6 bg-white border rounded-lg hover:bg-gray-50 text-center transition">
                        <i class="fa-solid fa-download fa-2x mb-3"></i>
                        <p class="font-semibold">Data Lengkap</p>
                        <p class="text-sm opacity-80">CSV format</p>
                    </a>
                    <a href="#" class="block p-6 bg-white border rounded-lg hover:bg-gray-50 text-center transition">
                        <i class="fa-solid fa-chart-bar fa-2x mb-3 text-gray-600"></i>
                        <p class="font-semibold text-gray-800">Laporan Kehadiran</p>
                        <p class="text-sm text-gray-500">Per hari event</p>
                    </a>
                    <a href="{{ route('admin.export.users.demographics') }}" class="block p-6 bg-white border rounded-lg hover:bg-gray-50 text-center transition">
                        <i class="fa-solid fa-map-location-dot fa-2x mb-3 text-gray-600"></i>
                        <p class="font-semibold text-gray-800">Data Demografi</p>
                        <p class="text-sm text-gray-500">Per wilayah</p>
                    </a>
                 </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-content');
            const exportDataBtn = document.getElementById('exportDataBtn');

            function switchTab(targetId) {
                contents.forEach(content => {
                    if (content.id === targetId) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });

                tabs.forEach(tab => {
                    if (tab.getAttribute('href') === '#' + targetId) {
                        tab.classList.add('border-teal-500', 'text-teal-600');
                        tab.classList.remove('border-transparent', 'text-gray-500');
                    } else {
                        tab.classList.remove('border-teal-500', 'text-teal-600');
                        tab.classList.add('border-transparent', 'text-gray-500');
                    }
                });
                // Simpan tab aktif ke URL
                history.pushState(null, null, window.location.pathname + '#' + targetId);
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    switchTab(targetId);
                });
            });

            exportDataBtn.addEventListener('click', function(e) {
                e.preventDefault();
                switchTab('laporan');
            });

            // Cek URL hash saat halaman dimuat
            const currentHash = window.location.hash.substring(1);
            if (currentHash) {
                const targetTab = document.querySelector(`.tab-link[href="#${currentHash}"]`);
                if(targetTab) {
                    switchTab(currentHash);
                }
            }
        });
    </script>
</x-admin-layout>
