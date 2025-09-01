<x-tenant-layout>
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('tenant.sales.index') }}" class="text-gray-600 hover:text-gray-900 font-semibold mb-6 inline-block"><i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Pilihan Input</a>
        
        <form action="{{ route('tenant.sales.store_detail') }}" method="POST">
            @csrf
            <div class="bg-white p-8 rounded-lg shadow-sm">
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4"><i class="fa-solid fa-file-invoice-dollar text-3xl text-gray-500"></i></div>
                    <h2 class="text-2xl font-bold text-gray-800">Input Detail Penjualan</h2>
                    <p class="text-gray-500 mt-2">Catat setiap transaksi untuk laporan yang lebih akurat.</p>
                </div>

                <div class="mt-8 border-t pt-8">
                    <div class="mb-6">
                        <label for="day_detail" class="block text-sm font-medium text-gray-700">Hari Penjualan</label>
                        <select name="day" id="day_detail" class="mt-1 w-full md:w-1/3 border-gray-300 rounded-lg" required>
                            <option value="1">Hari 1</option>
                            <option value="2">Hari 2</option>
                            <option value="3">Hari 3</option>
                        </select>
                    </div>

                    <h3 class="font-semibold text-lg mb-4">Item Penjualan</h3>
                    <div id="product-rows" class="space-y-4">
                        <!-- Baris item akan ditambahkan oleh JavaScript di sini -->
                    </div>

                    <button type="button" id="add-row" class="mt-4 px-4 py-2 border border-dashed rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-100"><i class="fa-solid fa-plus mr-2"></i>Tambah Item</button>
                </div>

                <div class="mt-8 border-t pt-6 flex justify-end items-center space-x-4">
                    <div>
                        <span class="text-gray-500">Total Keseluruhan:</span>
                        <span id="grand-total" class="font-bold text-xl">Rp 0</span>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg font-semibold">Simpan Detail Penjualan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addRowBtn = document.getElementById('add-row');
            const productRowsContainer = document.getElementById('product-rows');
            const grandTotalEl = document.getElementById('grand-total');
            let rowIndex = 0;

            function addProductRow() {
                const row = document.createElement('div');
                row.classList.add('grid', 'grid-cols-12', 'gap-3', 'items-center', 'product-row');
                row.innerHTML = `
                    <div class="col-span-5"><input type="text" name="products[${rowIndex}][name]" placeholder="Nama Produk" class="w-full border-gray-300 rounded-lg" required></div>
                    <div class="col-span-2"><input type="number" name="products[${rowIndex}][quantity]" placeholder="Jml" class="w-full border-gray-300 rounded-lg quantity" required></div>
                    <div class="col-span-3"><input type="number" name="products[${rowIndex}][price]" placeholder="Harga Satuan" class="w-full border-gray-300 rounded-lg price" required></div>
                    <div class="col-span-1"><p class="text-sm font-semibold text-right row-total">Rp 0</p></div>
                    <div class="col-span-1 text-right"><button type="button" class="text-red-500 hover:text-red-700 remove-row"><i class="fa-solid fa-trash"></i></button></div>
                `;
                productRowsContainer.appendChild(row);
                rowIndex++;
            }

            function updateTotals() {
                let grandTotal = 0;
                document.querySelectorAll('.product-row').forEach(row => {
                    const quantity = row.querySelector('.quantity').value || 0;
                    const price = row.querySelector('.price').value || 0;
                    const rowTotal = quantity * price;
                    row.querySelector('.row-total').textContent = 'Rp ' + rowTotal.toLocaleString('id-ID');
                    grandTotal += rowTotal;
                });
                grandTotalEl.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
            }

            addRowBtn.addEventListener('click', addProductRow);

            productRowsContainer.addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('price')) {
                    updateTotals();
                }
            });

            productRowsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    e.target.closest('.product-row').remove();
                    updateTotals();
                }
            });

            // Tambah satu baris saat halaman dimuat
            addProductRow();
        });
    </script>
</x-tenant-layout>
