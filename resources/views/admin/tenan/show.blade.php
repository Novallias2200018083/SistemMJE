<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <div>
                <p class="text-gray-500 text-sm">Detail Tenan</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $tenant->tenant_name }}</h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded-full">{{ $tenant->category }}</span>
                    @if($tenant->sales_input_method)
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            {{ $tenant->sales_input_method === 'detail' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($tenant->sales_input_method) }} Method
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.tenan.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Penjualan</p>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalSales) }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fa-solid fa-sack-dollar text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Jumlah Transaksi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalTransactions }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fa-solid fa-receipt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Peringkat Kategori</p>
                        <p class="text-2xl font-bold text-gray-800">#{{ $categoryRank }}</p>
                        <p class="text-xs text-gray-500">dari {{ $totalInCategory }} tenan</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fa-solid fa-trophy text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Peringkat Umum</p>
                        <p class="text-2xl font-bold text-gray-800">#{{ $overallRank }}</p>
                        <p class="text-xs text-gray-500">dari {{ $totalAllTenants }} tenan</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fa-solid fa-medal text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Rata-rata/Hari</p>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($averageSalesPerDay) }}</p>
                    </div>
                    <div class="bg-teal-100 p-3 rounded-full">
                        <i class="fa-solid fa-chart-line text-teal-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-lg text-gray-800">Grafik Penjualan Harian</h3>
                        <div class="text-sm text-gray-500">Event Period: 12-14 Sep 2025</div>
                    </div>
                    @if($totalSales > 0)
                        <div class="relative">
                            <canvas id="salesChart" height="300"></canvas>
                        </div>
                        <div class="flex justify-center mt-4 space-x-6">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-teal-500 rounded"></div>
                                <span class="text-sm text-gray-600">Penjualan Aktual</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-orange-400 rounded"></div>
                                <span class="text-sm text-gray-600">Target</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16 text-gray-400">
                            <i class="fa-solid fa-chart-simple fa-4x mb-4"></i>
                            <p class="text-lg font-medium">Belum Ada Data Penjualan</p>
                            <p class="text-sm">Grafik akan muncul setelah tenan melakukan transaksi</p>
                        </div>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <h3 class="font-bold text-lg mb-6">Analisis Performa Harian</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($salesPerDay as $data)
                            @php
                                $percentage = $data['target'] > 0 ? ($data['total'] / $data['target']) * 100 : 0;
                                $isTargetMet = $percentage >= 100;
                            @endphp
                            <div class="text-center p-4 rounded-lg {{ $isTargetMet ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200' }}">
                                <div class="text-2xl font-bold {{ $isTargetMet ? 'text-green-600' : 'text-gray-600' }} mb-2">
                                    Hari ke-{{ $data['day_number'] }}
                                </div>
                                <div class="text-lg font-semibold text-gray-800 mb-1">
                                    Rp {{ number_format($data['total']) }}
                                </div>
                                <div class="text-xs text-gray-500 mb-3">
                                    Target: Rp {{ number_format($data['target']) }}
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                                    <div class="{{ $isTargetMet ? 'bg-green-500' : 'bg-orange-400' }} h-3 rounded-full transition-all duration-300"
                                         style="width: {{ min($percentage, 100) }}%"></div>
                                </div>
                                <div class="text-sm font-medium {{ $isTargetMet ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ number_format($percentage, 1) }}%
                                    @if($isTargetMet)
                                        <i class="fa-solid fa-check-circle ml-1"></i>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <h3 class="font-bold text-lg mb-4">Informasi Tenan</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-user text-gray-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Pemilik</p>
                                <p class="font-medium">{{ $tenant->user->name ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-envelope text-gray-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $tenant->user->email ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-phone text-gray-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Telepon</p>
                                <p class="font-medium">{{ $tenant->user->phone_number ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-cog text-gray-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Metode Input</p>
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $tenant->sales_input_method === 'detail' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($tenant->sales_input_method ?? 'Belum Dipilih') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <h3 class="font-bold text-lg mb-4">Ringkasan Statistik</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Hari Terbaik:</span>
                            <span class="font-semibold">
                                {{ 'Hari ' . ($bestDay['day_number'] ?? '-') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Target:</span>
                            <span class="font-semibold">Rp {{ number_format($totalTarget) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pencapaian Target:</span>
                            <span class="font-semibold {{ $totalTarget > 0 && $totalSales >= $totalTarget ? 'text-green-600' : 'text-orange-600' }}">
                                {{ $targetAchievementPercentage }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <h3 class="font-bold text-lg text-gray-800">Riwayat Transaksi Lengkap</h3>
                <div class="flex items-center gap-4">
                    <form action="{{ route('admin.tenan.show', $tenant) }}" method="GET" class="flex items-center gap-4">
                        <div class="relative w-full max-w-xs">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fa-solid fa-search text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                        </div>
                        <div class="relative">
                            <select name="sort" onchange="this.form.submit()" 
                                    class="block w-full px-4 py-2 text-sm font-medium rounded-lg border 
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 
                                           hover:bg-gray-100 transition-colors">
                                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="highest_amount" {{ request('sort') === 'highest_amount' ? 'selected' : '' }}>Penjualan Tertinggi</option>
                                <option value="lowest_amount" {{ request('sort') === 'lowest_amount' ? 'selected' : '' }}>Penjualan Terendah</option>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fa-solid fa-filter"></i> Cari
                        </button>
                        <a href="{{ route('admin.tenan.show', $tenant) }}" class="px-4 py-2 border border-gray-300 font-semibold rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                            Reset
                        </a>
                    </form>
                </div>
            </div>
            
            @if($allSalesForListing->isNotEmpty())
                <div class="flex flex-wrap gap-2 mb-6">
                    <a href="{{ route('admin.tenan.show', ['tenan' => $tenant, 'day' => 'all', 'sort' => request('sort'), 'search' => request('search')]) }}"
                       class="filter-btn px-4 py-2 text-sm font-medium rounded-lg {{ request('day', 'all') === 'all' ? 'filter-active' : '' }}">
                        Semua ({{ $totalTransactions }})
                    </a>
                    @foreach($salesPerDay as $dayData)
                        <a href="{{ route('admin.tenan.show', ['tenan' => $tenant, 'day' => $dayData['day_number'], 'sort' => request('sort'), 'search' => request('search')]) }}"
                           class="filter-btn px-4 py-2 text-sm font-medium rounded-lg {{ request('day') == $dayData['day_number'] ? 'filter-active' : '' }}">
                            Hari {{ $dayData['day_number'] }} ({{ $dayData['transactions'] }})
                        </a>
                    @endforeach
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                     @foreach ($allSalesForListing as $sale)
                        <div class="transaction-item border rounded-lg p-4 transition-colors"
                             data-day="{{ $sale->day_number }}"
                             data-products="{{ $sale->details->pluck('product_name')->implode(', ') }}">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="font-semibold text-gray-800">
                                            Transaksi #{{ $sale->tenant_sale_id }}
                                        </h4>
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                            Hari {{ $sale->day_number }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($sale->sale_date)->isoFormat('dddd, D MMM Y - HH:mm') }}
                                        </span>
                                    </div>
                                    <div class="transaction-details-content hidden space-y-3 pt-3">
                                        @if($sale->details->isNotEmpty())
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <div class="grid grid-cols-4 font-semibold text-gray-600 text-sm mb-2">
                                                    <span>Produk</span>
                                                    <span>Jumlah</span>
                                                    <span>Harga Satuan</span>
                                                    <span class="text-right">Subtotal</span>
                                                </div>
                                                @foreach ($sale->details as $detail)
                                                    <div class="grid grid-cols-4 gap-2 text-sm border-t pt-2 mt-2">
                                                        <span>{{ $detail->product_name }}</span>
                                                        <span>{{ $detail->quantity }}x</span>
                                                        <span>Rp {{ number_format($detail->price) }}</span>
                                                        <span class="font-medium text-right">Rp {{ number_format($detail->total_price) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($sale->image)
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-image text-green-600"></i>
                                                <a href="{{ asset('storage/' . $sale->image) }}"
                                                   target="_blank"
                                                   class="text-sm text-green-600 hover:text-green-800 hover:underline">
                                                    Lihat Bukti Transaksi
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end gap-2">
                                    <p class="text-2xl font-bold text-gray-800">
                                        Rp {{ number_format($sale->amount) }}
                                    </p>
                                    <div class="flex gap-2">
                                        <button class="expand-btn px-3 py-1 text-xs text-white bg-gray-400 rounded hover:bg-gray-500 transition-colors">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $sale->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-4">
                        {{ $allSalesForListing->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-16 text-gray-400">
                    <i class="fa-solid fa-receipt fa-4x mb-4"></i>
                    <p class="text-lg font-medium">Belum Ada Transaksi</p>
                    <p class="text-sm">Tenan ini belum melakukan transaksi apapun</p>
                </div>
            @endif
        </div>
    </div>
    
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Hapus Transaksi</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="items-center px-4 py-3 flex justify-center gap-2">
                    <button id="modal-cancel-btn" class="px-4 py-2 bg-gray-200 text-gray-700 text-base font-medium rounded-md hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <form id="delete-form" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md hover:bg-red-600 transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        @if($totalSales > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('salesChart');
                const salesData = @json($salesPerDay->pluck('total'));
                const targetData = @json($salesPerDay->pluck('target'));
                const labels = @json($salesPerDay->pluck('day_number')->map(fn($day) => 'Hari ke-' . $day));

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Penjualan Aktual',
                                data: salesData,
                                backgroundColor: 'rgba(20, 184, 166, 0.8)',
                                borderColor: 'rgba(15, 118, 110, 1)',
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false,
                            },
                            {
                                label: 'Target',
                                data: targetData,
                                backgroundColor: 'rgba(251, 146, 60, 0.6)',
                                borderColor: 'rgba(234, 88, 12, 1)',
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        </script>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const transactionItems = document.querySelectorAll('.transaction-item');

                // Expand/Collapse transaction details
                transactionItems.forEach(item => {
                    const expandBtn = item.querySelector('.expand-btn');
                    const content = item.querySelector('.transaction-details-content');
                    
                    expandBtn.addEventListener('click', () => {
                        content.classList.toggle('hidden');
                        expandBtn.querySelector('i').classList.toggle('fa-chevron-down');
                        expandBtn.querySelector('i').classList.toggle('fa-chevron-up');
                    });
                });

                // Delete Modal Logic
                const deleteModal = document.getElementById('deleteModal');
                const modalCancelBtn = document.getElementById('modal-cancel-btn');
                const deleteForm = document.getElementById('delete-form');
                
                window.confirmDelete = function(saleId) {
                    deleteForm.action = `/admin/sales/${saleId}`;
                    deleteModal.classList.remove('hidden');
                }

                modalCancelBtn.addEventListener('click', () => {
                    deleteModal.classList.add('hidden');
                });

                deleteModal.addEventListener('click', (e) => {
                    if (e.target === deleteModal) {
                        deleteModal.classList.add('hidden');
                    }
                });
            });
        </script>

        <style>
            .filter-btn {
                @apply relative pb-2;
            }
            .filter-btn.active {
                @apply text-blue-600;
            }
            .filter-btn.active:after {
                content: '';
                @apply absolute bottom-0 left-0 w-full h-0.5 bg-blue-600;
            }
            .filter-btn:hover:not(.active) {
                @apply text-gray-800;
            }
            /* Custom scrollbar for transaction list */
            .overflow-y-auto::-webkit-scrollbar {
                width: 6px;
            }
            .overflow-y-auto::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }
            .overflow-y-auto::-webkit-scrollbar-thumb {
                background: #c5c5c5;
                border-radius: 10px;
            }
            .overflow-y-auto::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }
        </style>
    @endpush
</x-admin-layout>