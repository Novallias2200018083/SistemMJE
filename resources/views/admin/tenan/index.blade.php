<x-admin-layout>
    {{-- Header Halaman --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Manajemen Tenan</h2>
            <p class="text-gray-500 mt-1">Kelola, analisis, dan buat laporan untuk semua tenan yang terdaftar.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-6">
            <div class="bg-teal-100 text-teal-600 rounded-full h-16 w-16 flex items-center justify-center">
                <i class="fa-solid fa-store fa-2x"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Tenan Terdaftar</p>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($totalTenants) }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-6">
            <div class="bg-sky-100 text-sky-600 rounded-full h-16 w-16 flex items-center justify-center">
                <i class="fa-solid fa-sack-dollar fa-2x"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Penjualan Event</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-6" id="tabs">
                <a href="#daftar" class="tab-link py-2 px-1 border-b-2 border-teal-500 font-semibold text-teal-600">Daftar Tenan</a>
                <a href="#analisis" class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Analisis Kategori</a>
                <a href="#laporan" class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Unduh Laporan</a>
            </nav>
        </div>

        @if (session('success'))
            <div class="p-4 my-6 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div id="tab-contents" class="mt-6">
            <div id="daftar" class="tab-content">
                <form action="{{ route('admin.tenan.index') }}" method="GET" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div class="md:col-span-2">
                            <label for="search" class="text-sm font-medium text-gray-700">Cari Nama Tenan</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Contoh: Kopi Kenangan" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label for="category" class="text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category" id="category" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit" class="w-full bg-gray-800 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200">Filter</button>
                            <a href="{{ route('admin.tenan.index') }}" class="w-full text-center bg-gray-200 text-gray-700 py-2 px-4 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tenan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Total Penjualan</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tenans as $tenant)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600">
                                                {{ substr($tenant->tenant_name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-gray-900">{{ $tenant->tenant_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $tenant->category }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">Rp {{ number_format($tenant->sales_sum_amount, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.tenan.show', $tenant->id) }}" class="text-teal-600 hover:text-teal-900 p-2 rounded-full hover:bg-teal-50" title="Lihat Detail"><i class="fa-solid fa-eye fa-fw"></i></a>
                                            <form action="{{ route('admin.tenan.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Yakin hapus tenan ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50" title="Hapus Tenan"><i class="fa-solid fa-trash fa-fw"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                        <i class="fa-solid fa-store-slash fa-3x mb-4 text-gray-300"></i>
                                        <p class="font-semibold">Tidak Ada Tenan Ditemukan</p>
                                        <p class="text-sm">Coba ubah filter pencarian Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $tenans->appends(request()->query())->links() }}</div>
            </div>

            <div id="analisis" class="tab-content hidden">
                <div class="max-w-3xl mx-auto space-y-4">
                    <h3 class="text-xl font-bold text-center text-gray-800 mb-6">Distribusi Tenan per Kategori</h3>
                    @forelse ($categoryDistribution as $category => $total)
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium text-gray-700">{{ ucfirst($category) }}</span>
                                <span class="font-bold text-gray-900">{{ $total }} Tenan</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-teal-500 h-2.5 rounded-full" style="width: {{ $totalTenants > 0 ? ($total / $totalTenants) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">Tidak ada data kategori untuk dianalisis.</p>
                    @endforelse
                </div>
            </div>

            <div id="laporan" class="tab-content hidden">
                 <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @php
                        $reports = [
                            ['route' => 'admin.export.tenants.complete', 'icon' => 'fa-database', 'title' => 'Data Lengkap', 'subtitle' => 'CSV / Excel'],
                            ['route' => 'admin.export.tenants.sales', 'icon' => 'fa-sack-dollar', 'title' => 'Penjualan per Tenant', 'subtitle' => 'Excel / PDF'],
                            ['route' => 'admin.export.tenants.categories', 'icon' => 'fa-chart-pie', 'title' => 'Penjualan per Kategori', 'subtitle' => 'Excel / PDF'],
                            ['route' => 'admin.export.tenants.daily', 'icon' => 'fa-calendar-day', 'title' => 'Laporan Harian', 'subtitle' => 'Excel / PDF'],
                            ['route' => 'admin.export.tenants.summary', 'icon' => 'fa-clipboard-list', 'title' => 'Ringkasan', 'subtitle' => 'PDF'],
                        ];
                    @endphp
                    @foreach($reports as $report)
                    <a href="{{ route($report['route']) }}" class="block p-6 bg-white border rounded-lg hover:bg-gray-50/50 text-center transition duration-200 hover:shadow-md hover:border-teal-500 hover:-translate-y-1">
                        <i class="fa-solid {{ $report['icon'] }} fa-2x mb-3 text-teal-600"></i>
                        <p class="font-semibold text-gray-800">{{ $report['title'] }}</p>
                        <p class="text-sm text-gray-500">{{ $report['subtitle'] }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Script Tab tidak berubah, hanya perbaikan kecil --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-content');

            function switchTab(targetId) {
                contents.forEach(content => {
                    content.classList.toggle('hidden', content.id !== targetId);
                });
                tabs.forEach(tab => {
                    const isActive = tab.getAttribute('href') === '#' + targetId;
                    tab.classList.toggle('border-teal-500', isActive);
                    tab.classList.toggle('text-teal-600', isActive);
                    tab.classList.toggle('font-semibold', isActive);
                    tab.classList.toggle('border-transparent', !isActive);
                    tab.classList.toggle('text-gray-500', !isActive);
                });
                if (window.location.hash !== '#' + targetId) {
                    history.pushState(null, null, window.location.pathname + '#' + targetId);
                }
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    switchTab(targetId);
                });
            });

            const currentHash = window.location.hash.substring(1);
            if (currentHash && document.getElementById(currentHash)) {
                switchTab(currentHash);
            } else {
                switchTab('daftar');
            }
        });
    </script>
</x-admin-layout>