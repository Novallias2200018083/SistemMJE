<x-tenant-layout>
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Tenan</h2>
            <p class="text-gray-500">Selamat datang, {{ $tenant->tenant_name }}</p>
        </div>
        <div class="flex space-x-2">
            <!-- Tombol Riwayat Penjualan -->
            <a href="{{ route('tenant.sales.history') }}"
                class="px-4 py-2 bg-white border text-gray-700 rounded-lg font-semibold hover:bg-gray-50"><i
                    class="fa-solid fa-clock-rotate-left mr-2"></i>Riwayat</a>
            <a href="{{ route('tenant.sales.index') }}"
                class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700"><i
                    class="fa-solid fa-plus mr-2"></i>Input Penjualan</a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-6 p-1 bg-white rounded-xl shadow-sm border flex space-x-1 max-w-sm">
        <a href="{{ route('tenant.dashboard', ['day' => 1]) }}"
            class="w-full text-center px-4 py-2 rounded-lg font-semibold transition-colors duration-200 {{ $selectedDay == 1 ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            Hari 1
        </a>
        <a href="{{ route('tenant.dashboard', ['day' => 2]) }}"
            class="w-full text-center px-4 py-2 rounded-lg font-semibold transition-colors duration-200 {{ $selectedDay == 2 ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            Hari 2
        </a>
        <a href="{{ route('tenant.dashboard', ['day' => 3]) }}"
            class="w-full text-center px-4 py-2 rounded-lg font-semibold transition-colors duration-200 {{ $selectedDay == 3 ? 'bg-gray-800 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
            Hari 3
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Total Penjualan</p>
            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Selama 3 hari event</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Penjualan Hari Ke-{{ $selectedDay }}</p>
            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($daySalesData, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Total penjualan di hari terpilih</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Ranking Kategori</p>
            <p class="text-3xl font-bold text-gray-800">#{{ $rank }}</p>
            <p class="text-xs text-gray-400">dari {{ $totalTenantsInCategory }} tenan
                {{ Str::title(str_replace('_', ' ', $tenant->category)) }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Target Hari Ke-{{ $selectedDay }}</p>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($targetPercentage, 0) }}%</p>
                    <p class="text-xs text-gray-400">dari target Rp {{ number_format($dayTarget, 0, ',', '.') }}</p>
                </div>
                <button id="editTargetBtn" class="text-gray-400 hover:text-blue-600">
                    <i class="fa-solid fa-pencil"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
            <h3 class="font-bold text-lg mb-4">Grafik Penjualan per Hari</h3>
            <div class="space-y-4">
                @forelse($dailySalesChart as $day => $sale)
                    <div>
                        <div class="flex justify-between items-center mb-1"><span
                                class="font-semibold">{{ $day }}</span><span
                                class="font-semibold text-teal-600">Rp {{ number_format($sale, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-teal-500 h-4 rounded-full"
                                style="width: {{ $dailySalesChart->max() > 0 ? ($sale / $dailySalesChart->max()) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">Belum ada data penjualan.</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm text-center">
            <h3 class="font-bold text-lg mb-4">Statistik Kategori</h3>
            <i class="fa-solid fa-trophy text-7xl text-yellow-400"></i>
            <p class="mt-4 font-bold text-2xl">#{{ $rank }}</p>
            <p class="text-gray-500">Ranking di Kategori {{ Str::title(str_replace('_', ' ', $tenant->category)) }}</p>
            <div class="mt-6 text-left space-y-2 border-t pt-4">
                <div class="flex justify-between text-sm"><span class="text-gray-500">Total Penjualan</span><span
                        class="font-semibold">Rp {{ number_format($totalSales, 0, ',', '.') }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-gray-500">Hari Terbaik</span><span
                        class="font-semibold">Rp
                        {{ $dailySalesChart->max() > 0 ? number_format($dailySalesChart->max(), 0, ',', '.') : 0 }}</span>
                </div>
                <div class="flex justify-between text-sm"><span class="text-gray-500">Rata-rata Harian</span><span
                        class="font-semibold">Rp
                        {{ $dailySalesChart->count() > 0 ? number_format($dailySalesChart->avg(), 0, ',', '.') : 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <div id="targetModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-6">Ubah Target Penjualan per Hari</h3>
            <form action="{{ route('tenant.target.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <input type="hidden" name="current_day" value="{{ $selectedDay }}">

                <div class="space-y-4">
                    <div>
                        <label for="target_day_1" class="block text-sm font-medium text-gray-700">Target Hari 1
                            (Rp)</label>
                        <input type="number" name="target_day_1" id="target_day_1" value="{{ $tenant->target_day_1 }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0">
                    </div>
                    <div>
                        <label for="target_day_2" class="block text-sm font-medium text-gray-700">Target Hari 2
                            (Rp)</label>
                        <input type="number" name="target_day_2" id="target_day_2" value="{{ $tenant->target_day_2 }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0">
                    </div>
                    <div>
                        <label for="target_day_3" class="block text-sm font-medium text-gray-700">Target Hari 3
                            (Rp)</label>
                        <input type="number" name="target_day_3" id="target_day_3" value="{{ $tenant->target_day_3 }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="cancelBtn"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== BARU: Kartu Penjualan Terbaru ===== -->
    <div class="mt-6 bg-white p-6 rounded-lg shadow-sm">
        <h3 class="font-bold text-lg mb-4">Aktivitas Penjualan Terbaru</h3>
        <div class="space-y-4">
            @forelse($recentSales as $item)
                <div class="flex justify-between items-center border-b pb-3">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp
                            {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada aktivitas penjualan.</p>
            @endforelse
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editTargetBtn = document.getElementById('editTargetBtn');
                const targetModal = document.getElementById('targetModal');
                const cancelBtn = document.getElementById('cancelBtn');

                if (editTargetBtn) {
                    editTargetBtn.addEventListener('click', () => {
                        targetModal.classList.remove('hidden');
                    });
                }

                if (cancelBtn) {
                    cancelBtn.addEventListener('click', () => {
                        targetModal.classList.add('hidden');
                    });
                }

                if (targetModal) {
                    targetModal.addEventListener('click', (e) => {
                        if (e.target === targetModal) {
                            targetModal.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-tenant-layout>
