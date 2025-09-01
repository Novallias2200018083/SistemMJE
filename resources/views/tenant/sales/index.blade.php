<x-tenant-layout>
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('tenant.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-semibold mb-6 inline-block"><i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Dashboard</a>
        
        <div class="bg-white p-8 rounded-lg shadow-sm">
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-dollar-sign text-3xl text-gray-500"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Input Data Penjualan</h2>
                <p class="text-gray-500 mt-2">Input dan kelola data penjualan Anda untuk setiap hari event dengan transparansi dan akurasi.</p>
            </div>

            <div class="mt-8 border-t pt-8">
                <h3 class="font-semibold text-lg mb-4">Pilih Metode Input</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Opsi 1: Input Total Harian -->
                    <div class="border rounded-lg p-6">
                        <h4 class="font-bold">Input Total Harian (Cepat)</h4>
                        <p class="text-sm text-gray-500 mt-1 mb-4">Cukup masukkan total penjualan untuk satu hari.</p>
                        <form action="{{ route('tenant.sales.store') }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label for="day" class="text-sm">Hari Penjualan</label>
                                <select name="day" id="day" class="mt-1 w-full border-gray-300 rounded-lg" required>
                                    <option value="1">Hari 1</option>
                                    <option value="2">Hari 2</option>
                                    <option value="3">Hari 3</option>
                                </select>
                            </div>
                            <div>
                                <label for="amount" class="text-sm">Total Penjualan (Rp)</label>
                                <input type="number" name="amount" id="amount" placeholder="5000000" class="mt-1 w-full border-gray-300 rounded-lg" required>
                            </div>
                            <button type="submit" class="w-full py-2 bg-gray-800 text-white rounded-lg font-semibold">Simpan Total</button>
                        </form>
                    </div>
                    <!-- Opsi 2: Input Detail -->
                    <a href="{{ route('tenant.sales.create_detail') }}" class="border rounded-lg p-6 flex flex-col items-center justify-center text-center bg-gray-50 hover:bg-gray-100 transition">
                        <i class="fa-solid fa-file-invoice-dollar text-4xl text-gray-400 mb-4"></i>
                        <h4 class="font-bold">Input Detail Penjualan</h4>
                        <p class="text-sm text-gray-500 mt-1 mb-4">Catat setiap transaksi untuk laporan yang lebih detail dan akurat.</p>
                        <span class="w-full py-2 bg-teal-600 text-white rounded-lg font-semibold">Mulai Input Detail</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
