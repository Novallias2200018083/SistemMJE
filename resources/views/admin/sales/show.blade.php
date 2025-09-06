<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-sm text-gray-500">Detail Transaksi</p>
                    <h2 class="text-2xl font-bold text-gray-800">Transaksi #{{ $sale->tenant_sale_id }}</h2>
                </div>
                <a href="{{ route('admin.tenan.show', $sale->tenant_id) }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Tanggal Transaksi</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($sale->sale_date)->isoFormat('dddd, D MMMM Y - HH:mm') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Penjualan</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($sale->amount) }}</p>
                </div>
            </div>

            @if($sale->details->isNotEmpty())
                <div class="mb-6">
                    <p class="font-bold text-lg mb-4">Detail Produk</p>
                    <div class="bg-gray-50 p-4 rounded-lg border">
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
                </div>
            @endif

            @if($sale->image)
                <div>
                    <p class="font-bold text-lg mb-4">Bukti Transaksi</p>
                    <a href="{{ asset('storage/' . $sale->image) }}" target="_blank" class="block w-full max-w-sm rounded-lg overflow-hidden border hover:opacity-80 transition-opacity">
                        <img src="{{ asset('storage/' . $sale->image) }}" alt="Bukti Transaksi" class="w-full h-auto">
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>