<x-admin-layout>
    <x-slot name="header">Manajemen Tenan</x-slot>
    <x-slot name="subheader">Kelola data tenan</x-slot>

    <!-- Header & Tombol Aksi -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Tenan</h2>
            <p class="text-gray-500">Kelola tenan yang terdaftar di event</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.tenan.create') }}"
                class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">
                <i class="fa-solid fa-plus mr-2"></i>Tambah Tenan
            </a>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="flex justify-center mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-10 w-full max-w-4xl">
            <div class="bg-white p-10 rounded-2xl shadow-sm text-center">
                <p class="text-gray-500 text-lg">Total Tenan</p>
                <p class="text-5xl font-bold text-gray-800">{{ number_format($totalTenants) }}</p>
            </div>
            <div class="bg-white p-10 rounded-2xl shadow-sm text-center">
                <p class="text-gray-500 text-lg">Total Penjualan</p>
                <p class="text-5xl font-bold text-gray-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Konten Utama dengan Tabs -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-6" id="tabs">
                <a href="#daftar"
                    class="tab-link py-2 px-1 border-b-2 border-teal-500 font-semibold text-teal-600">Daftar Tenan</a>
                <a href="#analisis"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Analisis</a>
                <a href="#laporan"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Laporan</a>
            </nav>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div id="tab-contents">
            <!-- Tab: Daftar Tenant -->
            <div id="daftar" class="tab-content">
                <form action="{{ route('admin.tenan.index') }}" method="GET">
                    <div
                        class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end p-4 border rounded-lg mb-6">
                        <div>
                            <label for="search" class="text-sm font-medium">Pencarian</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Nama Tenan" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label for="category" class="text-sm font-medium">Kategori</label>
                            <select name="category" id="category"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="">Semua</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}"
                                        {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="bg-gray-800 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-700 h-10">Filter</button>
                    </div>
                </form>

                <div class="space-y-4">
                    @forelse($tenans as $tenant)
                        <div
                            class="bg-white border rounded-lg p-4 flex flex-wrap items-center justify-between gap-4 hover:bg-gray-50">
                            <div>
                                <p class="font-bold text-gray-800">{{ $tenant->tenant_name }}</p>
                                <p class="text-sm text-gray-500">{{ $tenant->category }}</p>
                                <div class="flex items-center gap-x-4 text-sm mt-2">
                                    <span><i class="fa-solid fa-sack-dollar mr-1"></i> Rp
                                        {{ number_format($tenant->sales_sum_amount, 0, ',', '.') }}
                                    </span>
                                    {{-- <span><i class="fa-solid fa-bullseye mr-1"></i> Target H1: Rp
                                        {{ number_format($tenant->target_day_1) }}</span> --}}
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.tenan.edit', $tenant->id) }}"
                                    class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 text-sm hover:bg-gray-100">
                                    <i class="fa-solid fa-pencil mr-2"></i>Edit
                                </a>
                                <form action="{{ route('admin.tenan.destroy', $tenant->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus tenan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 border border-red-300 rounded-lg font-semibold text-red-700 text-sm hover:bg-red-50">
                                        <i class="fa-solid fa-trash mr-2"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-500">
                            <i class="fa-solid fa-store-slash fa-3x mb-4"></i>
                            <p>Tidak ada tenan ditemukan.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-6">{{ $tenans->appends(request()->query())->links() }}</div>
            </div>

            <!-- Tab: Analisis -->
            <div id="analisis" class="tab-content hidden">
                <div class="space-y-4">
                    @foreach ($categoryDistribution as $category => $total)
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ ucfirst($category) }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ $total }} Tenan</span>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="w-full bg-gray-100 rounded-full h-3">
                                <div class="bg-blue-500 h-3 rounded-full"
                                    style="width: {{ ($total / $totalTenants) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Tab: Laporan -->
            <div id="laporan" class="tab-content hidden">
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    {{-- Data Lengkap --}}
                    <a href="{{ route('admin.export.tenants.complete') }}"
                        class="block p-6 bg-white border rounded-lg hover:bg-gray-50 text-center transition">
                        <i class="fa-solid fa-database fa-2x mb-3 text-blue-600"></i>
                        <p class="font-semibold">Data Lengkap</p>
                        <p class="text-sm opacity-80">CSV / Excel</p>
                    </a>

                    {{-- Laporan Penjualan per Tenant --}}
                    <a href="{{ route('admin.export.tenants.sales') }}"
                        class="block p-6 bg-white border rounded-lg hover:bg-gray-50 text-center transition">
                        <i class="fa-solid fa-sack-dollar fa-2x mb-3 text-green-600"></i>
                        <p class="font-semibold">Penjualan per Tenant</p>
                        <p class="text-sm opacity-80">Excel / PDF</p>
                    </a>

                    {{-- Laporan Penjualan per Kategori --}}
                    <a href="{{ route('admin.export.tenants.categories') }}"
                        class="block p-6 bg-white border rounded-lg hover:bg-gray-50 text-center transition">
                        <i class="fa-solid fa-chart-pie fa-2x mb-3 text-purple-600"></i>
                        <p class="font-semibold">Penjualan per Kategori</p>
                        <p class="text-sm opacity-80">Excel / PDF</p>
                    </a>

                    {{-- Laporan Harian --}}
                    <a href="{{ route('admin.export.tenants.daily') }}"
                        class="block p-6 bg-white border rounded-lg hover:bg-gray-50 text-center transition">
                        <i class="fa-solid fa-calendar-day fa-2x mb-3 text-indigo-600"></i>
                        <p class="font-semibold">Laporan Harian</p>
                        <p class="text-sm opacity-80">Excel / PDF</p>
                    </a>

                    {{-- Ringkasan Cepat --}}
                    <a href="{{ route('admin.export.tenants.summary') }}"
                        class="block p-6 bg-white border rounded-lg hover:bg-gray-50 text-center transition">
                        <i class="fa-solid fa-clipboard-list fa-2x mb-3 text-yellow-600"></i>
                        <p class="font-semibold">Ringkasan</p>
                        <p class="text-sm opacity-80">PDF</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-content');

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
                history.pushState(null, null, window.location.pathname + '#' + targetId);
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    switchTab(targetId);
                });
            });

            const currentHash = window.location.hash.substring(1);
            if (currentHash) {
                const targetTab = document.querySelector(`.tab-link[href="#${currentHash}"]`);
                if (targetTab) switchTab(currentHash);
            }
        });
    </script>
</x-admin-layout>
