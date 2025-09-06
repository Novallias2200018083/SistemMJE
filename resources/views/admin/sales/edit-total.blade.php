<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-sm text-gray-500">Edit Transaksi</p>
                    <h2 class="text-2xl font-bold text-gray-800">Transaksi #{{ $sale->tenant_sale_id }}</h2>
                </div>
                <a href="{{ route('admin.tenan.show', $sale->tenant_id) }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>Kembali
                </a>
            </div>

            <form action="{{ route('admin.sales.update', $sale) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="form-group">
                        <label for="day" class="block text-sm font-medium text-gray-700">Hari Event</label>
                        <select name="day" id="day" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="1" {{ $day == 1 ? 'selected' : '' }}>Hari 1</option>
                            <option value="2" {{ $day == 2 ? 'selected' : '' }}>Hari 2</option>
                            <option value="3" {{ $day == 3 ? 'selected' : '' }}>Hari 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Total Penjualan (Rp)</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $sale->amount) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="image" class="block text-sm font-medium text-gray-700">Bukti Transaksi</label>
                        <input type="file" name="image" id="image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @if($sale->image)
                            <p class="text-xs text-gray-500 mt-2">File saat ini: <a href="{{ asset('storage/' . $sale->image) }}" target="_blank" class="text-blue-500 hover:underline">Lihat Gambar</a></p>
                        @endif
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>