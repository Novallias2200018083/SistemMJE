<x-tenant-layout>
    {{-- Header Halaman --}}
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Riwayat Penjualan</h2>
            <p class="text-gray-500 mt-1">Analisis, kelola, dan ekspor data penjualan Anda.</p>
        </div>
        <a href="{{ route('tenant.sales.index') }}" class="px-5 py-2.5 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200 flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>Input Penjualan</span>
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm border border-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border"><p class="text-gray-500 text-sm">Total Penjualan (Hasil Filter)</p><p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalFilteredSales) }}</p></div>
        <div class="bg-white p-6 rounded-xl shadow-sm border"><p class="text-gray-500 text-sm">Jumlah Transaksi</p><p class="text-2xl font-bold text-gray-800">{{ number_format($totalFilteredTransactions) }}</p></div>
        <div class="bg-white p-6 rounded-xl shadow-sm border"><p class="text-gray-500 text-sm">Rata-rata per Transaksi</p><p class="text-2xl font-bold text-gray-800">Rp {{ $totalFilteredTransactions > 0 ? number_format($totalFilteredSales / $totalFilteredTransactions) : 0 }}</p></div>
    </div>
    
    <div class="bg-white p-4 rounded-xl shadow-sm border mb-6">
        <div class="border-b mb-4">
            <nav class="-mb-px flex gap-x-4">
                <a href="{{ route('tenant.sales.history', array_merge(request()->except('page'), ['day' => 'all'])) }}" class="px-3 py-2 font-semibold text-sm border-b-2 {{ $selectedDay == 'all' ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Semua Hari</a>
                <a href="{{ route('tenant.sales.history', array_merge(request()->except('page'), ['day' => 1])) }}" class="px-3 py-2 font-semibold text-sm border-b-2 {{ $selectedDay == 1 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 1</a>
                <a href="{{ route('tenant.sales.history', array_merge(request()->except('page'), ['day' => 2])) }}" class="px-3 py-2 font-semibold text-sm border-b-2 {{ $selectedDay == 2 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 2</a>
                <a href="{{ route('tenant.sales.history', array_merge(request()->except('page'), ['day' => 3])) }}" class="px-3 py-2 font-semibold text-sm border-b-2 {{ $selectedDay == 3 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 3</a>
            </nav>
        </div>

        <form method="GET" action="{{ url()->current() }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
            <input type="hidden" name="day" value="{{ $selectedDay }}">
            
            <div class="md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
            </div>

            <div class="md:col-span-1">
                <select name="sort" id="sort-select" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                    <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="highest_amount" {{ request('sort') == 'highest_amount' ? 'selected' : '' }}>Penjualan Tertinggi</option>
                    <option value="lowest_amount" {{ request('sort') == 'lowest_amount' ? 'selected' : '' }}>Penjualan Terendah</option>
                </select>
            </div>
            
            <div class="md:col-span-2 flex items-center space-x-2">
                <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold"><i class="fa-solid fa-filter mr-2"></i>Cari</button>
                <a href="{{ route('tenant.sales.export', request()->query()) }}" class="w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold"><i class="fa-solid fa-file-excel mr-2"></i>Ekspor</a>
            </div>
        </form>
    </div>
    
    <div class="space-y-4">
        @forelse($sales as $sale)
        <article class="bg-white p-4 rounded-xl shadow-sm border transition-shadow hover:shadow-md">
            <div class="grid grid-cols-12 gap-4 items-center">
                <div class="col-span-12 md:col-span-6">
                    <p class="font-bold text-gray-800">Transaksi #{{ $sale->tenant_sale_id }}</p>
                    <p class="text-sm text-gray-500"><i class="fa-regular fa-calendar-alt fa-fw mr-1"></i>{{ $sale->created_at->translatedFormat('l, d F Y - H:i') }}</p>
                </div>
                <div class="col-span-7 md:col-span-3 text-left md:text-right">
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="font-bold text-lg text-green-600">Rp {{ number_format($sale->amount, 0, ',', '.') }}</p>
                </div>
                <div class="col-span-5 md:col-span-3 flex items-center justify-end space-x-1">
                    <button type="button" class="toggle-details-btn text-gray-500 hover:text-gray-800 p-2 rounded-full hover:bg-gray-100" data-target="details-{{$sale->id}}" title="Lihat Rincian">
                        <i class="fa-solid fa-chevron-down fa-fw transition-transform"></i>
                    </button>
                    <a href="{{ route('tenant.sales.show', $sale) }}" class="text-gray-500 hover:text-sky-600 p-2 rounded-full hover:bg-sky-50" title="Detail"><i class="fa-solid fa-eye fa-fw"></i></a>
                    <a href="{{ route('tenant.sales.edit', $sale) }}" class="text-gray-500 hover:text-blue-600 p-2 rounded-full hover:bg-blue-50" title="Edit"><i class="fa-solid fa-pencil fa-fw"></i></a>
                    <form action="{{ route('tenant.sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Yakin hapus transaksi ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-500 hover:text-red-600 p-2 rounded-full hover:bg-red-50" title="Hapus"><i class="fa-solid fa-trash fa-fw"></i></button>
                    </form>
                </div>
            </div>
            <div id="details-{{$sale->id}}" class="hidden mt-4 pt-4 border-t border-dashed">
                <table class="w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr><th class="py-1 px-2 font-medium">Produk</th><th class="py-1 px-2 font-medium">Jumlah</th><th class="py-1 px-2 font-medium">Harga Satuan</th><th class="py-1 px-2 font-medium text-right">Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($sale->details as $item)
                        <tr class="border-t"><td class="py-2 px-2">{{ $item->product_name }}</td><td class="py-2 px-2">{{ $item->quantity }}</td><td class="py-2 px-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td><td class="py-2 px-2 text-right font-semibold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </article>
        @empty
        <div class="bg-white text-center p-12 rounded-lg shadow-sm border">
            <i class="fa-solid fa-inbox text-5xl text-gray-300"></i>
            <h3 class="mt-4 text-xl font-bold text-gray-700">Tidak Ada Data Penjualan</h3>
            <p class="text-gray-500 mt-1">Tidak ada hasil yang cocok dengan filter atau pencarian Anda. Coba reset filter.</p>
        </div>
        @endforelse

        <div class="mt-6">
            {{ $sales->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Auto-submit form ketika dropdown 'Urutkan' diubah
            const sortSelect = document.getElementById('sort-select');
            if(sortSelect) {
                sortSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }

            // 2. Fungsionalitas buka/tutup rincian produk (accordion)
            const detailToggles = document.querySelectorAll('.toggle-details-btn');
            detailToggles.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.dataset.target;
                    const targetElement = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (targetElement) {
                        targetElement.classList.toggle('hidden');
                        icon.classList.toggle('rotate-180');
                    }
                });
            });
        });
    </script>
</x-tenant-layout>