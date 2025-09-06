<x-admin-layout>
    <x-slot name="header">Edit Peserta</x-slot>
    <x-slot name="subheader">Memperbarui data peserta: {{ $attendee->name }}</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Edit Peserta</h2>

        @if ($errors->any())
           @endif

        @php
            $standardRegencies = ['Kota Yogyakarta', 'Kabupaten Sleman', 'Kabupaten Bantul', 'Kabupaten Kulon Progo', 'Kabupaten Gunungkidul'];
            $isOtherRegency = !in_array(old('regency', $attendee->regency), $standardRegencies) && old('regency', $attendee->regency) !== 'Lain-lain';
        @endphp

        <form method="POST" action="{{ route('admin.users.update', $attendee->id) }}">
            @csrf
            @method('PATCH')
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $attendee->name) }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="full_address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea id="full_address" name="full_address" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('full_address', $attendee->full_address) }}</textarea>
                </div>
                
                <div>
                    <label for="regency_select" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                    <select id="regency_select" name="regency" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="" disabled>Pilih kabupaten/kota</option>
                        <option value="Kota Yogyakarta" {{ old('regency', $attendee->regency) == 'Kota Yogyakarta' ? 'selected' : '' }}>Kota Yogyakarta</option>
                        <option value="Kabupaten Sleman" {{ old('regency', $attendee->regency) == 'Kabupaten Sleman' ? 'selected' : '' }}>Kabupaten Sleman</option>
                        <option value="Kabupaten Bantul" {{ old('regency', $attendee->regency) == 'Kabupaten Bantul' ? 'selected' : '' }}>Kabupaten Bantul</option>
                        <option value="Kabupaten Kulon Progo" {{ old('regency', $attendee->regency) == 'Kabupaten Kulon Progo' ? 'selected' : '' }}>Kabupaten Kulon Progo</option>
                        <option value="Kabupaten Gunungkidul" {{ old('regency', $attendee->regency) == 'Kabupaten Gunungkidul' ? 'selected' : '' }}>Kabupaten Gunungkidul</option>
                        <option value="Lain-lain" {{ old('regency', $attendee->regency) == 'Lain-lain' || $isOtherRegency ? 'selected' : '' }}>Lain-lain</option>
                    </select>
                </div>

                <!-- Updated "Pekerjaan" field -->
                <div>
                    <label for="jobs_select" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan
                        <span class="text-red-500">*</span></label>
                    <select id="jobs_select" name="jobs" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                        <option value="" disabled selected>Pilih Pekerjaan</option>
                        <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                        <option value="Pegawai Negeri Sipil/PNS">Pegawai Negeri Sipil/PNS</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Wirausaha">Wirausaha</option>
                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                        <option value="Tenaga Medis">Tenaga Medis</option>
                        <option value="TNI/Polri">TNI/Polri</option>
                        <option value="Guru/Dosen">Guru/Dosen</option>
                        <option value="Petani">Petani</option>
                        <option value="Nelayan">Nelayan</option>
                        <option value="Buruh">Buruh</option>
                    </select>
                </div>

                
                <div id="other_regency_wrapper" class="{{ $isOtherRegency || old('regency') === 'Lain-lain' ? '' : 'hidden' }}">
                    <label for="other_regency" class="block text-sm font-medium text-gray-700">Masukkan Nama Kabupaten/Kota Anda</label>
                    <input id="other_regency" name="other_regency" type="text" value="{{ old('other_regency', $isOtherRegency ? $attendee->regency : '') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                        <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number', $attendee->phone_number) }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Usia</label>
                        <input id="age" name="age" type="number" value="{{ old('age', $attendee->age) }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100">Batal</a>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">Update Peserta</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="{{ asset('js/regency-handler.js') }}"></script>
    @endpush
</x-admin-layout>