<x-tenant-layout>
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Penjualan</h2>
            <p class="text-gray-500">Filter, cari, dan ekspor data penjualan Anda.</p>
        </div>
         <a href="{{ route('tenant.sales.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700"><i class="fa-solid fa-plus mr-2"></i>Input Penjualan</a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-lg shadow-sm border mb-6">
        <div class="flex border-b mb-4">
            <a href="{{ route('tenant.sales.history', request()->except('day')) }}" class="px-4 py-2 font-semibold border-b-2 {{ $selectedDay == 'all' ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Semua Hari</a>
            <a href="{{ route('tenant.sales.history', array_merge(request()->except('day'), ['day' => 1])) }}" class="px-4 py-2 font-semibold border-b-2 {{ $selectedDay == 1 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 1</a>
            <a href="{{ route('tenant.sales.history', array_merge(request()->except('day'), ['day' => 2])) }}" class="px-4 py-2 font-semibold border-b-2 {{ $selectedDay == 2 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 2</a>
            <a href="{{ route('tenant.sales.history', array_merge(request()->except('day'), ['day' => 3])) }}" class="px-4 py-2 font-semibold border-b-2 {{ $selectedDay == 3 ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Hari 3</a>
        </div>

        <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="hidden" name="day" value="{{ $selectedDay }}">
            
            <div class="md:col-span-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <div class="md:col-span-1">
                <select name="sort" class="w-full border-gray-300 rounded-lg shadow-sm">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Urutkan: Terlama</option>
                    <option value="highest_amount" {{ request('sort') == 'highest_amount' ? 'selected' : '' }}>Urutkan: Penjualan Tertinggi</option>
                    <option value="lowest_amount" {{ request('sort') == 'lowest_amount' ? 'selected' : '' }}>Urutkan: Penjualan Terendah</option>
                </select>
            </div>
            
            <div class="md:col-span-1 flex items-center space-x-2">
                <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold"><i class="fa-solid fa-filter mr-2"></i>Terapkan</button>
                <a href="{{ route('tenant.sales.export', request()->query()) }}" class="w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold"><i class="fa-solid fa-file-excel mr-2"></i>Ekspor</a>
            </div>
        </form>
    </div>
    
    <div class="space-y-6">
        @forelse($sales as $sale)
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex flex-wrap justify-between items-center gap-3 pb-4 border-b">
                <div>
                    <p class="font-bold text-lg">Transaksi #{{ $sale->tenant_sale_id }}</p>
                    <p class="text-sm text-gray-500">{{ $sale->created_at->translatedFormat('l, d F Y - H:i') }}</p>
                </div>
                <div class="text-right">
                     <p class="text-sm text-gray-500">Total Transaksi</p>
                     <p class="font-bold text-xl text-green-600">Rp {{ number_format($sale->amount, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="mt-4">
                <table class="w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr><th class="py-1 px-2 font-medium">Produk</th><th class="py-1 px-2 font-medium">Jumlah</th><th class="py-1 px-2 font-medium">Harga Satuan</th><th class="py-1 px-2 font-medium text-right">Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($sale->details as $item)
                        <tr class="border-t">
                            <td class="py-2 px-2">{{ $item->product_name }}</td>
                            <td class="py-2 px-2">{{ $item->quantity }}</td>
                            <td class="py-2 px-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-2 px-2 text-right font-semibold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="bg-white text-center p-12 rounded-lg shadow-sm border">
            <i class="fa-solid fa-inbox text-4xl text-gray-300"></i>
            <h3 class="mt-4 text-xl font-bold text-gray-700">Tidak Ada Data Penjualan</h3>
            <p class="text-gray-500 mt-1">Tidak ada hasil yang cocok dengan filter atau pencarian Anda.</p>
        </div>
        @endforelse

        <div class="mt-6">
            {{ $sales->links() }}
        </div>
    </div>
</x-tenant-layout>