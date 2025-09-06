<x-admin-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('admin.tenan.index') }}" class="text-gray-600 hover:text-gray-900 font-semibold inline-block mb-4">
                <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Manajemen Tenan
            </a>
            <h2 class="text-3xl font-bold text-gray-800">Tambah Tenan Baru</h2>
            <p class="text-gray-600 mt-2">Buat akun dan profil untuk tenan baru secara manual.</p>
        </div>

        <div class="w-full bg-white p-8 rounded-2xl shadow-xl border">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Pembuatan Akun Gagal</p>
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
                    {{-- Informasi Tenan --}}
                    <div>
                        <label for="tenant_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Tenan / Usaha</label>
                        <input id="tenant_name" name="tenant_name" type="text" value="{{ old('tenant_name') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                    </div>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik Akun</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                            <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                    </div>
                     <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori Tenan</label>
                        <select id="category" name="category" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                            {{-- Menggunakan $categories dari controller --}}
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <hr class="border-dashed"/>
                    
                    {{-- Informasi Login --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email (untuk login)</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</hlabel>
                            <input id="password" name="password" type="password" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 px-6 rounded-xl hover:bg-gray-700 transition-all duration-300 flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-plus mr-3"></i>
                        Buat Akun Tenan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>