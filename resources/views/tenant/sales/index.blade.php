<x-tenant-layout>
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('tenant.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-semibold mb-6 inline-block"><i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Dashboard</a>
        
        <div class="bg-white p-8 rounded-lg shadow-sm">
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-dollar-sign text-3xl text-gray-500"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Input Data Penjualan</h2>
                <p class="text-gray-500 mt-2">Input dan kelola data penjualan Anda untuk setiap hari event.</p>
            </div>

            <div class="mt-8 border-t pt-8">
                
                {{-- ====================================================== --}}
                {{-- KONDISI 1: TENAN BELUM PERNAH MEMILIH METODE INPUT --}}
                {{-- ====================================================== --}}
                @if (is_null($tenant->sales_input_method))
                    <h3 class="font-semibold text-lg mb-2">Pilih Metode Input Penjualan</h3>
                    <p class="text-sm text-gray-500 mb-4">Peringatan: Pilihan ini bersifat <span class="font-bold text-red-600">permanen</span>. Setelah Anda menyimpan data pertama, Anda tidak dapat mengubah metode input.</p>

                    <div class="space-y-3">
                        {{-- Pilihan Radio Button --}}
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <input id="method_total" name="input_method" type="radio" data-target="form-total" class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                            <label for="method_total" class="ml-3 block text-sm font-medium text-gray-700">
                                Input Total Harian (Cepat)
                            </label>
                        </div>
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <input id="method_detail" name="input_method" type="radio" data-target="form-detail" class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                            <label for="method_detail" class="ml-3 block text-sm font-medium text-gray-700">
                                Input Detail Penjualan (Akurat)
                            </label>
                        </div>
                    </div>
                    
                    <hr class="my-6 border-dashed">
                    
                    {{-- Kontainer untuk Form/Tombol yang akan dikontrol oleh JavaScript --}}
                    <div id="method-forms-container">
                        <div id="form-total" class="hidden">
                            <div class="border rounded-lg p-6">
                                <h4 class="font-bold">Input Total Harian (Cepat)</h4>
                                <p class="text-sm text-gray-500 mt-1 mb-4">Cukup masukkan total penjualan untuk satu hari.</p>
                                
                                @if ($errors->any())
                                    <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                        <ul class="list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('tenant.sales.store') }}" method="POST" class="space-y-3" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <label for="day" class="text-sm">Hari Penjualan</label>
                                        <select name="day" id="day" class="mt-1 w-full border-gray-300 rounded-lg" required>
                                            <option value="1">Hari 1 (12 Sep 2025)</option>
                                            <option value="2">Hari 2 (13 Sep 2025)</option>
                                            <option value="3">Hari 3 (14 Sep 2025)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="amount" class="text-sm">Total Penjualan (Rp)</label>
                                        <input type="number" name="amount" id="amount" placeholder="5000000" class="mt-1 w-full border-gray-300 rounded-lg" required>
                                    </div>
                                    <div>
                                        <label for="image" class="text-sm">Upload Bukti Transaksi (Opsional)</label>
                                        <input type="file" name="image" id="image" class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                    </div>
                                    <button type="submit" class="w-full py-2 bg-gray-800 text-white rounded-lg font-semibold">Simpan Total</button>
                                </form>
                            </div>
                        </div>

                        <div id="form-detail" class="hidden">
                             <a href="{{ route('tenant.sales.create_detail') }}" class="border rounded-lg p-6 flex flex-col items-center justify-center text-center bg-gray-50 hover:bg-gray-100 transition">
                                <i class="fa-solid fa-file-invoice-dollar text-4xl text-gray-400 mb-4"></i>
                                <h4 class="font-bold">Input Detail Penjualan</h4>
                                <p class="text-sm text-gray-500 mt-1 mb-4">Catat setiap transaksi untuk laporan yang lebih detail dan akurat.</p>
                                <span class="w-full py-2 bg-teal-600 text-white rounded-lg font-semibold">Mulai Input Detail</span>
                            </a>
                        </div>
                    </div>

                {{-- ====================================================== --}}
                {{-- KONDISI 2: TENAN SUDAH MEMILIH "TOTAL" --}}
                {{-- ====================================================== --}}
                @elseif ($tenant->sales_input_method == 'total')
                    <div class="p-4 text-sm text-blue-700 bg-blue-100 rounded-lg mb-6" role="alert">
                        Anda telah memilih metode <span class="font-bold">Input Total Harian</span>. Pilihan ini tidak dapat diubah.
                    </div>
                    <div class="border rounded-lg p-6">
                        <h4 class="font-bold">Input Total Harian (Cepat)</h4>
                        <p class="text-sm text-gray-500 mt-1 mb-4">Cukup masukkan total penjualan untuk satu hari.</p>
                        
                        @if ($errors->any())
                            <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('tenant.sales.store') }}" method="POST" class="space-y-3" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="day" class="text-sm">Hari Penjualan</label>
                                <select name="day" id="day" class="mt-1 w-full border-gray-300 rounded-lg" required>
                                    <option value="1">Hari 1 (12 Sep 2025)</option>
                                    <option value="2">Hari 2 (13 Sep 2025)</option>
                                    <option value="3">Hari 3 (14 Sep 2025)</option>
                                </select>
                            </div>
                            <div>
                                <label for="amount" class="text-sm">Total Penjualan (Rp)</label>
                                <input type="number" name="amount" id="amount" placeholder="5000000" class="mt-1 w-full border-gray-300 rounded-lg" required>
                            </div>
                            <div>
                                <label for="image" class="text-sm">Upload Bukti Transaksi (Opsional)</label>
                                <input type="file" name="image" id="image" class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            </div>
                            <button type="submit" class="w-full py-2 bg-gray-800 text-white rounded-lg font-semibold">Simpan Total</button>
                        </form>
                    </div>

                {{-- ====================================================== --}}
                {{-- KONDISI 3: TENAN SUDAH MEMILIH "DETAIL" --}}
                {{-- ====================================================== --}}
                @elseif ($tenant->sales_input_method == 'detail')
                    <div class="p-4 text-sm text-blue-700 bg-blue-100 rounded-lg mb-6" role="alert">
                        Anda telah memilih metode <span class="font-bold">Input Detail Penjualan</span>. Pilihan ini tidak dapat diubah.
                    </div>
                    <a href="{{ route('tenant.sales.create_detail') }}" class="border rounded-lg p-6 flex flex-col items-center justify-center text-center bg-gray-50 hover:bg-gray-100 transition">
                        <i class="fa-solid fa-file-invoice-dollar text-4xl text-gray-400 mb-4"></i>
                        <h4 class="font-bold">Input Detail Penjualan</h4>
                        <p class="text-sm text-gray-500 mt-1 mb-4">Catat setiap transaksi untuk laporan yang lebih detail dan akurat.</p>
                        <span class="w-full py-2 bg-teal-600 text-white rounded-lg font-semibold">Mulai Input Detail</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Script ini hanya akan dirender jika tenan BELUM memilih metode --}}
    @if (is_null($tenant->sales_input_method))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="input_method"]');
            const methodForms = {
                'form-total': document.getElementById('form-total'),
                'form-detail': document.getElementById('form-detail')
            };

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Sembunyikan semua form/tombol terlebih dahulu
                    Object.values(methodForms).forEach(form => form.classList.add('hidden'));

                    // Tampilkan form/tombol yang sesuai dengan radio yang dipilih
                    if (this.checked) {
                        const targetId = this.getAttribute('data-target');
                        if (methodForms[targetId]) {
                            methodForms[targetId].classList.remove('hidden');
                        }
                    }
                });
            });
        });
    </script>
    @endif
</x-tenant-layout>