<x-tenant-layout>
    <div class="max-w-xl mx-auto">
        <a href="{{ route('tenant.sales.history') }}" class="text-gray-600 hover:text-gray-900 font-semibold mb-6 inline-block"><i class="fa-solid fa-arrow-left mr-2"></i>Batal & Kembali ke Riwayat</a>

        <div class="bg-white p-8 rounded-lg shadow-sm border">
            <h2 class="text-2xl font-bold text-gray-800 mb-1">Edit Penjualan Total</h2>
            <p class="text-gray-500 mb-6">Transaksi #{{ $sale->tenant_sale_id }}</p>

            @if ($errors->any())
                <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tenant.sales.update', $sale) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="day" class="block text-sm font-medium">Hari Penjualan</label>
                    <select name="day" id="day" class="mt-1 w-full rounded-lg border-gray-300" required>
                        <option value="1" {{ old('day', $day) == 1 ? 'selected' : '' }}>Hari 1</option>
                        <option value="2" {{ old('day', $day) == 2 ? 'selected' : '' }}>Hari 2</option>
                        <option value="3" {{ old('day', $day) == 3 ? 'selected' : '' }}>Hari 3</option>
                    </select>
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium">Total Penjualan (Rp)</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount', $sale->amount) }}" class="mt-1 w-full rounded-lg border-gray-300" required>
                </div>
                <div>
                    <label for="image" class="block text-sm font-medium">Ganti Bukti Transaksi (Opsional)</label>
                    <input type="file" name="image" id="image" class="mt-1 w-full text-sm">
                    @if($sale->image)
                        <p class="text-xs text-gray-500 mt-2">Bukti saat ini: <a href="{{ asset('storage/' . $sale->image) }}" target="_blank" class="text-sky-600 hover:underline">Lihat Gambar</a></p>
                    @endif
                </div>

                <div class="pt-4 border-t">
                    <button type="submit" class="w-full py-3 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-700">Update Penjualan</button>
                </div>
            </form>
        </div>
    </div>
</x-tenant-layout>