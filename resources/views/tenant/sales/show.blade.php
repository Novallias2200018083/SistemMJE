<x-tenant-layout>
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('tenant.sales.history') }}" class="text-gray-600 hover:text-gray-900 font-semibold mb-6 inline-block"><i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Riwayat</a>

        <div class="bg-white p-8 rounded-lg shadow-sm border">
            <div class="flex flex-wrap justify-between items-start gap-4 pb-4 border-b">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Detail Transaksi #{{ $sale->tenant_sale_id }}</h2>
                    <p class="text-gray-500">{{ $sale->created_at->translatedFormat('l, d F Y - H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="font-bold text-2xl text-green-600">Rp {{ number_format($sale->amount, 0, ',', '.') }}</p>
                </div>
            </div>

            @if($sale->image)
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Bukti Transaksi</h3>
                    <a href="{{ asset('storage/' . $sale->image) }}" target="_blank">
                        <img src="{{ asset('storage/' . $sale->image) }}" alt="Bukti Transaksi" class="max-w-sm rounded-lg border shadow-sm">
                    </a>
                </div>
            @endif

            <div class="mt-6">
                <h3 class="font-semibold mb-2">Rincian Produk</h3>
                <table class="w-full text-sm">
                    <thead class="text-left text-gray-500 bg-gray-50">
                        <tr><th class="py-2 px-3 font-medium">Produk</th><th class="py-2 px-3 font-medium">Jumlah</th><th class="py-2 px-3 font-medium">Harga Satuan</th><th class="py-2 px-3 font-medium text-right">Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($sale->details as $item)
                        <tr class="border-b">
                            <td class="py-3 px-3">{{ $item->product_name }}</td>
                            <td class="py-3 px-3">{{ $item->quantity }}</td>
                            <td class="py-3 px-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-right font-semibold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-tenant-layout>