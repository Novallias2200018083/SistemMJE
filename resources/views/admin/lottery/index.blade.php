<x-admin-layout>
    <x-slot name="header">Pengundian</x-slot>
    <x-slot name="subheader">Doorprize & undian</x-slot>

    <!-- Header & Tombol Aksi -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pengundian Doorprize</h2>
            <p class="text-gray-500">Kelola hadiah dan lakukan pengundian untuk peserta event</p>
        </div>
        <div class="flex space-x-2">
            <button class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100"><i
                    class="fa-solid fa-download mr-2"></i>Export Pemenang</button>
            <a href="{{ route('admin.lottery.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100"><i
                    class="fa-solid fa-arrows-rotate mr-2"></i>Refresh</a>
            <button onclick="openModal()"
                class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700"><i
                    class="fa-solid fa-plus mr-2"></i>Mulai Undian</button>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Total Hadiah</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalPrizes }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Sudah Diundi</p>
            <p class="text-3xl font-bold text-gray-800">{{ $drawnPrizes }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Sudah Diambil</p>
            <p class="text-3xl font-bold text-gray-800">{{ $claimedPrizes }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Peserta Eligible</p>
            <p class="text-3xl font-bold text-blue-600">{{ $eligibleAttendeesCount }}</p>
        </div>
    </div>


    <!-- Konten Utama dengan Tabs -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="flex justify-between items-center border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-6" id="tabs">
                <a href="#daftar-hadiah"
                    class="tab-link py-2 px-1 border-b-2 border-teal-500 font-semibold text-teal-600">Daftar Hadiah</a>
                <a href="#pemenang"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Pemenang</a>
                <a href="#riwayat"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Riwayat
                    Undian</a>
            </nav>
            <button onclick="openModal()"
                class="px-4 py-2 bg-teal-600 text-white rounded-lg font-semibold text-sm hover:bg-teal-700"><i
                    class="fa-solid fa-plus mr-2"></i>Tambah Hadiah</button>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ session('error') }}</div>
        @endif

        <div id="tab-contents">
            <!-- Tab: Daftar Hadiah -->
            <div id="daftar-hadiah" class="tab-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($prizes as $prize)
                    <div class="border rounded-lg p-4 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <span
                                    class="text-xs font-semibold bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">{{ $prize->category }}</span>
                                <span
                                    class="text-xs font-semibold bg-gray-100 text-gray-800 px-2 py-1 rounded-full">{{ $prize->quantity - $prize->winners_count }}
                                    tersisa</span>
                            </div>
                            <h3 class="font-bold text-lg mt-2">{{ $prize->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $prize->description }}</p>
                            <div class="mt-4 text-sm"><span class="text-gray-500">Nilai Hadiah</span>
                                <p class="font-semibold text-teal-600">Rp
                                    {{ number_format($prize->value, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-sm"><span class="text-gray-500">Sponsor</span>
                                <p class="font-semibold">{{ $prize->sponsor }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.lottery.draw', $prize->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="w-full py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700 disabled:bg-gray-400"
                                {{ $prize->quantity - $prize->winners_count <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-dice-d6 mr-2"></i>Undi Sekarang
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500 py-12">Belum ada hadiah yang ditambahkan.</p>
                @endforelse
            </div>

            <!-- Tab: Pemenang -->
            <div id="pemenang" class="tab-content hidden space-y-3">
                @forelse($winners as $winner)
                    <div class="border rounded-lg p-4 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                <i class="fa-solid fa-trophy fa-lg"></i></div>
                            <div>
                                <p class="font-bold">{{ $winner->attendee->name }}</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $winner->prize->name }}</p>
                                <p class="text-xs text-gray-500">{{ $winner->attendee->token }} &bull;
                                    {{ $winner->attendee->phone_number }} &bull;
                                    {{ $winner->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if ($winner->is_claimed)
                                <span class="px-4 py-2 text-sm font-semibold text-green-700 bg-green-100 rounded-lg"><i
                                        class="fa-solid fa-check-circle mr-2"></i>Sudah Diambil</span>
                            @else
                                <span class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg">Belum
                                    Diambil</span>
                                <form action="{{ route('admin.lottery.claim', $winner->id) }}" method="POST">@csrf
                                    @method('PATCH')<button type="submit"
                                        class="px-4 py-2 bg-teal-600 text-white rounded-lg font-semibold text-sm hover:bg-teal-700">Tandai
                                        Diambil</button></form>

                            {{-- Tombol WhatsApp --}}
                            @php
                                $phone = preg_replace('/^0/', '62', $winner->attendee->phone_number); 
                                $message = urlencode("Selamat {$winner->attendee->name}, Anda terpilih sebagai pemenang doorprize {$winner->prize->name} di acara Jogja Expo 2025. Apakah sodara berkenan untuk melakukan video call.");
                            @endphp
                            <a href="https://web.whatsapp.com/send?phone={{ $phone }}&text={{ $message }}" target="_blank"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700">
                            Hubungi via WA
                            </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-12">Belum ada pemenang yang diundi.</p>
                @endforelse
            </div>

            <!-- Tab: Riwayat Undian -->
            <div id="riwayat" class="tab-content hidden space-y-3">
                @forelse($winners as $winner)
                    <div class="border rounded-lg p-4 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $winner->prize->name }}</p>
                            <p class="text-sm">Pemenang: <span
                                    class="font-semibold">{{ $winner->attendee->name }}</span>
                                ({{ $winner->attendee->token }})</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">Rp {{ number_format($winner->prize->value, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">{{ $winner->created_at->format('d/m/Y, H:i') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-12">Belum ada riwayat pengundian.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Tambah Hadiah -->
    <div id="prizeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-bold">Tambah Hadiah Baru</h3><button onclick="closeModal()"
                    class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form action="{{ route('admin.lottery.store') }}" method="POST" class="space-y-4">
                @csrf
                <div><label class="block text-sm font-medium">Nama Hadiah *</label><input type="text"
                        name="name" class="mt-1 w-full border-gray-300 rounded-lg" required></div>
                <div><label class="block text-sm font-medium">Deskripsi *</label>
                    <textarea name="description" rows="2" class="mt-1 w-full border-gray-300 rounded-lg" required></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium">Kategori *</label><input type="text"
                            name="category" placeholder="e.g. Hadiah Utama"
                            class="mt-1 w-full border-gray-300 rounded-lg" required></div>
                    <div><label class="block text-sm font-medium">Jumlah *</label><input type="number"
                            name="quantity" value="1" class="mt-1 w-full border-gray-300 rounded-lg" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium">Nilai Hadiah (Rp)</label><input type="number"
                            name="value" class="mt-1 w-full border-gray-300 rounded-lg"></div>
                    <div><label class="block text-sm font-medium">Sponsor</label><input type="text" name="sponsor"
                            class="mt-1 w-full border-gray-300 rounded-lg"></div>
                </div>
                <div class="flex justify-end space-x-3 mt-6 border-t pt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold">Simpan
                        Hadiah</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // --- Logika Tabs ---
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-content');

            function switchTab(targetId) {
                contents.forEach(c => c.id === targetId ? c.classList.remove('hidden') : c.classList.add('hidden'));
                tabs.forEach(t => {
                    t.classList.remove('border-teal-500', 'text-teal-600');
                    t.classList.add('border-transparent', 'text-gray-500');
                    if (t.getAttribute('href') === '#' + targetId) {
                        t.classList.add('border-teal-500', 'text-teal-600');
                        t.classList.remove('border-transparent', 'text-gray-500');
                    }
                });
                if (history.pushState) {
                    history.pushState(null, null, '#' + targetId);
                } else {
                    location.hash = '#' + targetId;
                }
            }
            tabs.forEach(tab => tab.addEventListener('click', e => {
                e.preventDefault();
                switchTab(e.target.getAttribute('href').substring(1));
            }));
            if (window.location.hash) {
                const targetTab = document.querySelector(`.tab-link[href="${window.location.hash}"]`);
                if (targetTab) targetTab.click();
            }
        });
        // --- Logika Modal ---
        const modal = document.getElementById('prizeModal');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }
    </script>
</x-admin-layout>
