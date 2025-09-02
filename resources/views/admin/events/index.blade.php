<x-admin-layout>
    <x-slot name="header">Manajemen Acara</x-slot>
    <x-slot name="subheader">Kelola jadwal event</x-slot>

    <!-- Header & Tombol Aksi -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Acara</h2>
            <p class="text-gray-500">Kelola jadwal dan detail acara event untuk setiap hari</p>
        </div>
        <div class="flex space-x-2">
            <button onclick="openModal()"
                class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700"><i
                    class="fa-solid fa-plus mr-2"></i>Tambah Event</button>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Total Event</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalEvents }}</p>
            <p class="text-xs text-gray-400">Semua hari event</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Hari 1</p>
            <p class="text-3xl font-bold text-gray-800">{{ $eventStats[1] ?? 0 }}</p>
            <p class="text-xs text-gray-400">Event terjadwal</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Hari 2</p>
            <p class="text-3xl font-bold text-gray-800">{{ $eventStats[2] ?? 0 }}</p>
            <p class="text-xs text-gray-400">Event terjadwal</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Hari 3</p>
            <p class="text-3xl font-bold text-gray-800">{{ $eventStats[3] ?? 0 }}</p>
            <p class="text-xs text-gray-400">Event terjadwal</p>
        </div>
    </div>

    <!-- Konten Utama dengan Tabs -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <!-- Navigasi Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-6" id="tabs">
                <a href="#jadwal"
                    class="tab-link py-2 px-1 border-b-2 border-teal-500 font-semibold text-teal-600">Jadwal Event</a>
                <a href="#daftar"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Daftar
                    Event</a>
            </nav>
        </div>

        <!-- Konten Tab -->
        <div id="tab-contents">
            <!-- Tab: Jadwal Event (Tampilan Kolom) -->
            <div id="jadwal" class="tab-content grid grid-cols-1 md:grid-cols-3 gap-6">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-lg">Hari {{ $i }}</h3>
                            {{-- [FIX] Menggunakan get() untuk menghindari error jika key tidak ada --}}
                            <span
                                class="text-xs font-semibold bg-gray-200 px-2 py-1 rounded-full">{{ $eventsByDay->get($i, collect())->count() }}
                                event</span>
                        </div>
                        <div class="space-y-3">
                            {{-- [FIX] Menggunakan get() dengan default array kosong --}}
                            @forelse($eventsByDay->get($i, []) as $event)
                                <div class="bg-white p-3 rounded-lg border">
                                    <div class="flex justify-between items-start">
                                        <p class="font-semibold">{{ $event->title }}</p>
                                        <div class="flex space-x-2 text-gray-400">
                                            <button onclick="editEvent({{ $event->id }})"
                                                class="hover:text-blue-600"><i class="fa-solid fa-pencil"></i></button>
                                            <form action="{{ route('admin.events.destroy', $event->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin hapus event ini?');">
                                                @csrf @method('DELETE')<button type="submit"
                                                    class="hover:text-red-600"><i
                                                        class="fa-solid fa-trash"></i></button></form>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2"><i
                                            class="fa-regular fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                        - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</p>
                                    <p class="text-xs text-gray-500"><i
                                            class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 text-center py-4">Belum ada event.</p>
                            @endforelse
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Tab: Daftar Event (Tampilan List) -->
            <div id="daftar" class="tab-content hidden">
                <form action="{{ route('admin.events.index') }}" method="GET" class="mb-6">
                    <div class="flex items-center space-x-4 p-4 border rounded-lg">
                        <label for="filter_day" class="font-medium">Filter Hari:</label>
                        <select name="filter_day" id="filter_day" class="border-gray-300 rounded-lg shadow-sm"
                            onchange="this.form.submit()">
                            <option value="">Semua Hari</option>
                            <option value="1" {{ request('filter_day') == 1 ? 'selected' : '' }}>Hari 1</option>
                            <option value="2" {{ request('filter_day') == 2 ? 'selected' : '' }}>Hari 2</option>
                            <option value="3" {{ request('filter_day') == 3 ? 'selected' : '' }}>Hari 3</option>
                        </select>
                    </div>
                </form>
                <div class="space-y-4">
                    @forelse($listedEvents as $event)
                        <div class="bg-white border rounded-lg p-4 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <p class="font-bold">{{ $event->title }} <span
                                        class="text-xs font-semibold bg-gray-100 px-2 py-1 rounded-full">Hari
                                        {{ $event->day }}</span></p>
                                <p class="text-sm text-gray-600 mt-1">{{ $event->description }}</p>
                                <div class="flex items-center space-x-4 text-sm text-gray-500 mt-2">
                                    <span><i
                                            class="fa-regular fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                        - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                                    <span><i class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}</span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="editEvent({{ $event->id }})"
                                    class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 text-sm hover:bg-gray-100"><i
                                        class="fa-solid fa-pencil mr-2"></i>Edit</button>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus event ini?');">@csrf @method('DELETE')<button
                                        type="submit"
                                        class="px-4 py-2 border border-red-300 rounded-lg font-semibold text-red-700 text-sm hover:bg-red-50"><i
                                            class="fa-solid fa-trash mr-2"></i>Hapus</button></form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">Tidak ada event yang cocok dengan filter.</p>
                    @endforelse
                </div>
            </div>

            <!-- Tab: Preview Publik -->
            <div id="preview" class="tab-content hidden">
                <p class="text-center text-gray-500 py-8">Tampilan preview publik akan muncul di sini.</p>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Event -->
    <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 id="modalTitle" class="text-xl font-bold">Tambah Event Baru</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="eventForm" method="POST">
                @csrf
                <div id="formMethod"></div>
                <div class="space-y-4">
                    <div><label for="title" class="block text-sm font-medium">Judul Acara *</label><input
                            type="text" name="title" id="title"
                            class="mt-1 w-full border-gray-300 rounded-lg" required></div>
                    <div><label for="description" class="block text-sm font-medium">Deskripsi *</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 w-full border-gray-300 rounded-lg"
                            required></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label for="day" class="block text-sm font-medium">Hari Event *</label><select
                                name="day" id="day" class="mt-1 w-full border-gray-300 rounded-lg"
                                required>
                                <option value="1">Hari 1</option>
                                <option value="2">Hari 2</option>
                                <option value="3">Hari 3</option>
                            </select></div>
                        <div><label for="location" class="block text-sm font-medium">Lokasi *</label><input
                                type="text" name="location" id="location"
                                class="mt-1 w-full border-gray-300 rounded-lg" required></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label for="start_time" class="block text-sm font-medium">Waktu Mulai *</label><input
                                type="datetime-local" name="start_time" id="start_time"
                                class="mt-1 w-full border-gray-300 rounded-lg" required></div>
                        <div><label for="end_time" class="block text-sm font-medium">Waktu Selesai *</label><input
                                type="datetime-local" name="end_time" id="end_time"
                                class="mt-1 w-full border-gray-300 rounded-lg" required></div>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6 border-t pt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded-lg">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // --- Logika Tabs ---
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    contents.forEach(content => content.id === targetId ? content.classList.remove(
                        'hidden') : content.classList.add('hidden'));
                    tabs.forEach(t => t.classList.remove('border-teal-500', 'text-teal-600') || t
                        .classList.add('border-transparent', 'text-gray-500'));
                    this.classList.add('border-teal-500', 'text-teal-600');
                    this.classList.remove('border-transparent', 'text-gray-500');
                });
            });
        });

        // --- Logika Modal ---
        const modal = document.getElementById('eventModal');
        const form = document.getElementById('eventForm');
        const modalTitle = document.getElementById('modalTitle');
        const formMethod = document.getElementById('formMethod');

        function openModal() {
            form.reset();
            form.action = "{{ route('admin.events.store') }}";
            modalTitle.textContent = "Tambah Event Baru";
            formMethod.innerHTML = "";
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        async function editEvent(id) {
            const response = await fetch(`/admin/events/${id}`);
            const event = await response.json();

            form.reset();
            form.action = `/admin/events/${id}`;
            modalTitle.textContent = "Edit Event";
            formMethod.innerHTML = `@method('PATCH')`;

            document.getElementById('title').value = event.title;
            document.getElementById('description').value = event.description;
            document.getElementById('location').value = event.location;
            document.getElementById('day').value = event.day;
            document.getElementById('start_time').value = event.start_time.slice(0, 16);
            document.getElementById('end_time').value = event.end_time.slice(0, 16);

            modal.classList.remove('hidden');
        }
    </script>
</x-admin-layout>
