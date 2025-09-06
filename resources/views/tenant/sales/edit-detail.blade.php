<x-tenant-layout>
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('tenant.sales.history') }}" class="text-gray-600 hover:text-gray-900 font-semibold mb-6 inline-block"><i class="fa-solid fa-arrow-left mr-2"></i>Batal & Kembali ke Riwayat</a>
        
        @if ($errors->any())
            {{-- ... Blok error ... --}}
        @endif

        <form id="edit-sale-form" action="{{ route('tenant.sales.update', $sale) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-white p-8 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Transaksi #{{ $sale->tenant_sale_id }}</h2>
                
                {{-- Form Content (mirip create-detail, tapi dengan value) --}}
                <div class="border-t pt-8">
                    <div class="mb-6">
                        <label for="day_detail" class="block text-sm font-medium">Hari Penjualan</label>
                        <select name="day" id="day_detail" class="mt-1 w-full md:w-1/3 rounded-lg" required>
                            <option value="1" {{ old('day', $day) == 1 ? 'selected' : '' }}>Hari 1</option>
                            <option value="2" {{ old('day', $day) == 2 ? 'selected' : '' }}>Hari 2</option>
                            <option value="3" {{ old('day', $day) == 3 ? 'selected' : '' }}>Hari 3</option>
                        </select>
                    </div>

                    <h3 class="font-semibold text-lg mb-4">Item Penjualan</h3>
                    <div id="product-rows" class="space-y-4">
                        @foreach(old('products', $sale->details) as $index => $item)
                             <div class="grid grid-cols-12 gap-3 items-center product-row">
                                <div class="col-span-5"><input type="text" name="products[{{$index}}][name]" value="{{ $item['product_name'] ?? $item['name'] }}" placeholder="Nama Produk" class="w-full rounded-lg" required></div>
                                <div class="col-span-2"><input type="number" name="products[{{$index}}][quantity]" value="{{ $item['quantity'] }}" placeholder="Jml" class="w-full rounded-lg quantity" required></div>
                                <div class="col-span-3"><input type="number" name="products[{{$index}}][price]" value="{{ $item['price'] }}" placeholder="Harga Satuan" class="w-full rounded-lg price" required></div>
                                <div class="col-span-1"><p class="text-sm font-semibold text-right row-total">Rp 0</p></div>
                                <div class="col-span-1 text-right"><button type="button" class="text-red-500 remove-row"><i class="fa-solid fa-trash"></i></button></div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-row" class="mt-4 text-sm font-semibold"><i class="fa-solid fa-plus mr-2"></i>Tambah Item</button>
                </div>

                {{-- ... Bagian Upload Gambar (dengan preview gambar lama) & Tombol Simpan ... --}}
                <div class="mt-8 border-t pt-6 flex justify-end">
                    <button id="submit-button" type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg font-semibold">Update Transaksi</button>
                </div>
            </div>
        </form>
    </div>

    {{-- 2. TEMPLATE UNTUK BARIS PRODUK (BEST PRACTICE) --}}
    <template id="product-row-template">
        <div class="grid grid-cols-12 gap-3 items-center product-row">
            <div class="col-span-5"><input type="text" name="products[__INDEX__][name]" placeholder="Nama Produk" class="w-full border-gray-300 rounded-lg" required></div>
            <div class="col-span-2"><input type="number" name="products[__INDEX__][quantity]" placeholder="Jml" class="w-full border-gray-300 rounded-lg quantity" required></div>
            <div class="col-span-3"><input type="number" name="products[__INDEX__][price]" placeholder="Harga Satuan" class="w-full border-gray-300 rounded-lg price" required></div>
            <div class="col-span-1"><p class="text-sm font-semibold text-right row-total">Rp 0</p></div>
            <div class="col-span-1 text-right"><button type="button" class="text-red-500 hover:text-red-700 remove-row"><i class="fa-solid fa-trash"></i></button></div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. INISIALISASI STATE APLIKASI
            const form = document.getElementById('detail-sale-form');
            const addRowBtn = document.getElementById('add-row');
            const productRowsContainer = document.getElementById('product-rows');
            const grandTotalEl = document.getElementById('grand-total');
            const submitButton = document.getElementById('submit-button');
            const imageInput = document.getElementById('image_detail');
            const imagePreview = document.getElementById('image-preview');
            const rowTemplate = document.getElementById('product-row-template');
            
            // Inisialisasi rowIndex berdasarkan baris yang sudah ada (dari old input)
            let rowIndex = {{ count(old('products', $sale->details)) }};

            // 2. FUNGSI-FUNGSI UTAMA (LEBIH TERSTRUKTUR)
            const addProductRow = () => {
                const newRow = rowTemplate.content.cloneNode(true);
                // Ganti placeholder __INDEX__ dengan rowIndex yang sebenarnya
                newRow.querySelector('[name="products[__INDEX__][name]"]').name = `products[${rowIndex}][name]`;
                newRow.querySelector('[name="products[__INDEX__][quantity]"]').name = `products[${rowIndex}][quantity]`;
                newRow.querySelector('[name="products[__INDEX__][price]"]').name = `products[${rowIndex}][price]`;
                
                productRowsContainer.appendChild(newRow);
                rowIndex++;
            };

            const updateTotals = () => {
                let grandTotal = 0;
                productRowsContainer.querySelectorAll('.product-row').forEach(row => {
                    const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                    const price = parseFloat(row.querySelector('.price').value) || 0;
                    const rowTotal = quantity * price;
                    row.querySelector('.row-total').textContent = 'Rp ' + rowTotal.toLocaleString('id-ID');
                    grandTotal += rowTotal;
                });
                grandTotalEl.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
            };

            const handleImagePreview = (event) => {
                const file = event.target.files[0];
                if (file) {
                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.classList.remove('hidden');
                } else {
                    imagePreview.classList.add('hidden');
                }
            };
            
            // 3. PENANGANAN EVENT (EVENT DELEGATION)
            addRowBtn.addEventListener('click', addProductRow);
            imageInput.addEventListener('change', handleImagePreview);

            productRowsContainer.addEventListener('input', (e) => {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('price')) {
                    updateTotals();
                }
            });

            productRowsContainer.addEventListener('click', (e) => {
                const removeBtn = e.target.closest('.remove-row');
                if (removeBtn) {
                    removeBtn.closest('.product-row').remove();
                    updateTotals();
                }
            });
            
            // 4. FEEDBACK SAAT SUBMIT FORM
            form.addEventListener('submit', () => {
                submitButton.disabled = true;
                submitButton.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-2"></i>Menyimpan...`;
            });

            // 5. INISIALISASI HALAMAN
            // Jika tidak ada baris produk sama sekali (bukan dari old input), tambahkan satu baris.
            if (productRowsContainer.children.length === 0) {
                addProductRow();
            } else {
                // Jika ada baris dari old input, hitung totalnya saat halaman dimuat
                updateTotals();
            }
        });
    </script>
</x-tenant-layout>