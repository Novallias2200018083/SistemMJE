<x-admin-layout>
    <x-slot name="header">Edit Tenant</x-slot>
    <x-slot name="subheader">Memperbarui data tenant: {{ $tenant->tenant_name }}</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Edit Tenant</h2>

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

        <form method="POST" action="{{ route('admin.tenan.update', $tenant->id) }}">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                {{-- Nama Tenant --}}
                <div>
                    <label for="tenant_name" class="block text-sm font-medium text-gray-700">Nama Tenant</label>
                    <input id="tenant_name" name="tenant_name" type="text"
                        value="{{ old('tenant_name', $tenant->tenant_name) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input id="category" name="category" type="text"
                        value="{{ old('category', $tenant->category) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Total Penjualan --}}
                <div>
                    <label for="total_sales" class="block text-sm font-medium text-gray-700">Total Penjualan</label>
                    <input id="total_sales" name="total_sales" type="number"
                        value="{{ old('total_sales', $tenant->total_sales) }}" min="0"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Target Harian --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="target_day_1" class="block text-sm font-medium text-gray-700">Target Hari 1</label>
                        <input id="target_day_1" name="target_day_1" type="number"
                            value="{{ old('target_day_1', $tenant->target_day_1) }}" min="0"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label for="target_day_2" class="block text-sm font-medium text-gray-700">Target Hari 2</label>
                        <input id="target_day_2" name="target_day_2" type="number"
                            value="{{ old('target_day_2', $tenant->target_day_2) }}" min="0"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label for="target_day_3" class="block text-sm font-medium text-gray-700">Target Hari 3</label>
                        <input id="target_day_3" name="target_day_3" type="number"
                            value="{{ old('target_day_3', $tenant->target_day_3) }}" min="0"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.tenan.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">Update
                    Tenant</button>
            </div>
        </form>
    </div>
</x-admin-layout>
