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

                    <div class="border rounded-md p-4">
                        <h3 class="text-lg font-bold mb-4">Detail Produk</h3>
                        <div id="products-container" class="space-y-4">
                            @foreach ($sale->details as $index => $detail)
                                <div class="product-item grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                    <div class="form-group">
                                        <label for="products-{{ $index }}-name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                        <input type="text" name="products[{{ $index }}][name]" id="products-{{ $index }}-name" value="{{ old('products.' . $index . '.name', $detail->product_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="products-{{ $index }}-quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                                        <input type="number" name="products[{{ $index }}][quantity]" id="products-{{ $index }}-quantity" value="{{ old('products.' . $index . '.quantity', $detail->quantity) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required min="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="products-{{ $index }}-price" class="block text-sm font-medium text-gray-700">Harga Satuan</label>
                                        <input type="number" name="products[{{ $index }}][price]" id="products-{{ $index }}-price" value="{{ old('products.' . $index . '.price', $detail->price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required min="0">
                                    </div>
                                    @if ($index > 0)
                                        <button type="button" class="remove-product px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors">Hapus</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-product" class="mt-4 px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors">Tambah Produk</button>
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.getElementById('products-container');
                const addButton = document.getElementById('add-product');
                let productIndex = container.children.length;

                addButton.addEventListener('click', () => {
                    const newItem = document.createElement('div');
                    newItem.classList.add('product-item', 'grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-4', 'items-end');
                    newItem.innerHTML = `
                        <div class="form-group">
                            <label for="products-${productIndex}-name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                            <input type="text" name="products[${productIndex}][name]" id="products-${productIndex}-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="products-${productIndex}-quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="products[${productIndex}][quantity]" id="products-${productIndex}-quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required min="1">
                        </div>
                        <div class="form-group">
                            <label for="products-${productIndex}-price" class="block text-sm font-medium text-gray-700">Harga Satuan</label>
                            <input type="number" name="products[${productIndex}][price]" id="products-${productIndex}-price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required min="0">
                        </div>
                        <button type="button" class="remove-product px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors">Hapus</button>
                    `;
                    container.appendChild(newItem);
                    productIndex++;
                });

                container.addEventListener('click', (e) => {
                    if (e.target.classList.contains('remove-product')) {
                        e.target.closest('.product-item').remove();
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>