<x-admin-layout>
    <x-slot name="header">Tambah Tenan</x-slot>
    <x-slot name="subheader">Menambahkan data tenan baru ke dalam sistem</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
        <div class="flex items-start space-x-4 mb-8">
            <div class="bg-green-100 text-green-600 p-4 rounded-xl">
                <i class="fa-solid fa-store fa-2x"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Form Tambah Tenan Baru</h2>
                <p class="text-gray-600 mt-1">Isi detail tenan di bawah ini untuk menambahkannya ke dalam sistem.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.tenan.store') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="tenant_name" class="block text-sm font-medium text-gray-700">Nama Tenan</label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-store text-gray-400"></i>
                        </div>
                        <input id="tenant_name" name="tenant_name" type="text" value="{{ old('tenant_name') }}"
                            required
                            class="block w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                      focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input id="category" name="category" type="text" value="{{ old('category') }}"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="total_sales" class="block text-sm font-medium text-gray-700">Total Penjualan Awal
                        (Rp)</label>
                    <input id="total_sales" name="total_sales" type="number" value="{{ old('total_sales', 0) }}"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="target_day_1" class="block text-sm font-medium text-gray-700">Target Hari 1</label>
                        <input id="target_day_1" name="target_day_1" type="number" value="{{ old('target_day_1', 0) }}"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="target_day_2" class="block text-sm font-medium text-gray-700">Target Hari 2</label>
                        <input id="target_day_2" name="target_day_2" type="number" value="{{ old('target_day_2', 0) }}"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="target_day_3" class="block text-sm font-medium text-gray-700">Target Hari 3</label>
                        <input id="target_day_3" name="target_day_3" type="number" value="{{ old('target_day_3', 0) }}"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.tenan.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-500">
                    Simpan Tenan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
