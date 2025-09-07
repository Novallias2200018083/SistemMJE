<x-admin-layout>
    <x-slot name="header">Tambah Peserta</x-slot>
    <x-slot name="subheader">Menambahkan data peserta baru secara manual</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
        <div class="flex items-start space-x-4 mb-8">
            <div class="bg-sky-100 text-sky-600 p-4 rounded-xl">
                <i class="fa-solid fa-user-plus fa-2x"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Form Tambah Peserta Baru</h2>
                <p class="text-gray-600 mt-1">Isi detail peserta di bawah ini untuk menambahkannya ke dalam sistem.</p>
            </div>
        </div>

        @if ($errors->any() && !$errors->has('phone_number'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-gray-400"></i>
                        </div>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required class="block w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                    </div>
                </div>

                <div>
                    <label for="full_address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea id="full_address" name="full_address" rows="3" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">{{ old('full_address') }}</textarea>
                </div>

                <div>
                    <label for="regency_select" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                    <select id="regency_select" name="regency" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                        <option value="" disabled selected>Pilih kabupaten/kota</option>
                        <option value="Kota Yogyakarta" {{ old('regency') == 'Kota Yogyakarta' ? 'selected' : '' }}>Kota Yogyakarta</option>
                        <option value="Kabupaten Sleman" {{ old('regency') == 'Kabupaten Sleman' ? 'selected' : '' }}>Kabupaten Sleman</option>
                        <option value="Kabupaten Bantul" {{ old('regency') == 'Kabupaten Bantul' ? 'selected' : '' }}>Kabupaten Bantul</option>
                        <option value="Kabupaten Kulon Progo" {{ old('regency') == 'Kabupaten Kulon Progo' ? 'selected' : '' }}>Kabupaten Kulon Progo</option>
                        <option value="Kabupaten Gunungkidul" {{ old('regency') == 'Kabupaten Gunungkidul' ? 'selected' : '' }}>Kabupaten Gunungkidul</option>
                        <option value="Lain-lain" {{ old('regency') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                    </select>
                </div>

                <div>
                    <label for="jobs_select" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan
                        <span class="text-red-500">*</span>
                    </label>
                    <select id="jobs_select" name="jobs" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                        <option value="" disabled selected>Pilih Pekerjaan</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                        <option value="Pelajar/Mahasiswa">Pelajar / Mahasiswa</option>
                        <option value="PNS/TNI/Polri">PNS / TNI / Polri</option>
                        <option value="Karyawan Swasta/Profesional">Karyawan Swasta / Profesional</option>
                        <option value="Wirausaha/Pengusaha/Pedagang">Wirausaha / Pengusaha / Pedagang</option>
                        <option value="Pekerja Harian">Pekerja Harian (Buruh, Tukang, dll.)</option>
                        <option value="Petani/Nelayan">Petani / Nelayan</option>
                        <option value="Guru/Dosen">Guru / Dosen</option>
                        <option value="Tenaga Medis">Tenaga Medis</option>
                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                        <option value="Pensiunan">Pensiunan</option>
                    </select>
                </div>
                
                <div id="other_regency_wrapper" class="hidden">
                    <label for="other_regency" class="block text-sm font-medium text-gray-700">Masukkan Nama Kabupaten/Kota</label>
                    <input id="other_regency" name="other_regency" type="text" value="{{ old('other_regency') }}" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-phone @error('phone_number') text-red-500 @else text-gray-400 @enderror"></i>
                            </div>
                            <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number') }}" required 
                                   class="block w-full pl-10 px-4 py-3 border rounded-lg shadow-sm 
                                          @error('phone_number') border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-sky-500 focus:border-sky-500 @enderror">
                        </div>
                        @error('phone_number')
                            <div class="flex items-center text-red-600 text-sm mt-2">
                                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Usia</label>
                        <div class="mt-1 relative">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-cake-candles text-gray-400"></i>
                            </div>
                            <input id="age" name="age" type="number" value="{{ old('age') }}" required class="block w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100">Batal</a>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">Simpan Peserta</button>
            </div>
        </form>
    </div>

    @push('scripts')
        {{-- Pastikan file ini ada di public/js/regency-handler.js --}}
        <script src="{{ asset('js/regency-handler.js') }}"></script>
    @endpush
</x-admin-layout>