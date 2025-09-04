<x-admin-layout>
    <x-slot name="header">Kelola Kehadiran</x-slot>
    <x-slot name="subheader">Input presensi peserta</x-slot>

    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Kehadiran</h2>
            <p class="text-gray-500">Input presensi peserta dengan dua metode: manual token atau centang massal</p>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Total Peserta</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalAttendees) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Kehadiran Hari 1</p>
            <p id="hadir-hari-1" class="text-3xl font-bold text-gray-800">{{ $dailyAttendance[1] ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Kehadiran Hari 2</p>
            <p id="hadir-hari-2" class="text-3xl font-bold text-gray-800">{{ $dailyAttendance[2] ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <p class="text-gray-500 text-sm">Kehadiran Hari 3</p>
            <p id="hadir-hari-3" class="text-3xl font-bold text-gray-800">{{ $dailyAttendance[3] ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="border-b border-gray-200 mb-6">
            <nav id="tabs"
                class="-mb-px flex space-x-6 overflow-x-auto scrollbar-hide md:overflow-visible md:flex-nowrap">

                <a href="#absen-scan"
                    class="tab-link py-2 px-1 border-b-2 border-teal-500 font-semibold text-teal-600 whitespace-nowrap">
                    Scan QR
                </a>
                <a href="#absen-manual"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    Absen Manual
                </a>
                <a href="#absen-massal"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    Absen Massal
                </a>
                <a href="#data-kehadiran"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    Data Kehadiran
                </a>
                <a href="#analisis"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    Analisis
                </a>
                <a href="#laporan"
                    class="tab-link py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    Laporan
                </a>
            </nav>
        </div>


        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ session('error') }}</div>
        @endif

        <div id="tab-contents">
            <div id="absen-manual" class="tab-content hidden">
                <h3 class="font-bold text-lg mb-2">Input Presensi Manual (Live Search)</h3>
                <p class="text-gray-500 mb-4">Ketik token peserta untuk melakukan check-in. Hasil akan muncul otomatis.
                </p>

                <div class="p-4 border rounded-lg">
                    <div class="flex items-end space-x-3">
                        <div class="flex-grow">
                            <label for="token-search-input" class="text-sm font-medium">Token Peserta</label>
                            <input type="text" id="token-search-input"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500"
                                placeholder="Mulai ketik token...">
                        </div>
                        <div>
                            <label for="day-select" class="text-sm font-medium">Hari Event</label>
                            <select id="day-select"
                                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                                <option value="1">Hari 1</option>
                                <option value="2">Hari 2</option>
                                <option value="3">Hari 3</option>
                            </select>
                        </div>
                    </div>

                    <div id="search-result-container"
                        class="mt-4 pt-4 border-t border-gray-200 min-h-[80px] flex items-center justify-center">
                        <p class="text-sm text-gray-500">Ketik token peserta untuk memulai pencarian.</p>
                    </div>
                </div>
            </div>

            {{-- Scan barcode --}}
            <div id="absen-scan" class="tab-content">
                <h3 class="font-bold text-lg mb-2">Input Presensi dengan Scan</h3>
                <p class="text-gray-500 mb-4">Pilih hari event lalu gunakan kamera untuk scan QR code peserta.</p>

                <div class="p-4 border rounded-lg">
                    <!-- Pilih Hari Event -->
                    <div class="mb-4">
                        <label for="scan-day-select" class="text-sm font-medium">Hari Event</label>
                        <select id="scan-day-select"
                            class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                            <option value="">-- Pilih Hari --</option>
                            <option value="1">Hari 1</option>
                            <option value="2">Hari 2</option>
                            <option value="3">Hari 3</option>
                        </select>
                    </div>

                    <!-- Tombol kontrol -->
                    <div class="flex items-center space-x-3 mb-4">
                        <button id="start-scan" class="px-4 py-2 bg-sky-600 text-white rounded-lg">Mulai Scan</button>
                        <button id="stop-scan" class="px-4 py-2 bg-red-600 text-white rounded-lg hidden">Stop
                            Scan</button>
                    </div>

                    <!-- Tempat preview kamera -->
                    <div id="reader" class="w-full max-w-md mx-auto"></div>

                    <div id="scan-result-container"
                        class="mt-4 pt-4 border-t border-gray-200 min-h-[80px] flex items-center justify-center">
                        <p class="text-sm text-gray-500">Pilih hari event lalu klik "Mulai Scan" untuk membuka kamera.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Library QR Scanner -->
            <script src="https://unpkg.com/html5-qrcode"></script>
            <script>
                let html5QrCode;

                function onScanSuccess(decodedText) {
                    const day = document.getElementById("scan-day-select").value;
                    if (!day) {
                        document.getElementById('scan-result-container').innerHTML =
                            `<p class="text-sm text-red-600 font-semibold">⚠️ Pilih hari event dulu sebelum scan.</p>`;
                        return;
                    }

                    document.getElementById('scan-result-container').innerHTML =
                        `<p class="text-sm text-blue-600">Memproses token <b>${decodedText}</b> untuk Hari ${day}...</p>`;

                    fetch(`/admin/attendance/store-ajax`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            },
                            body: JSON.stringify({
                                token: decodedText,
                                day: day
                            })
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.json().then(err => Promise.reject(err));
                            }
                            return res.json();
                        })
                        .then(data => {
                            document.getElementById('scan-result-container').innerHTML =
                                `<p class="text-sm text-green-600 font-semibold">${data.message}</p>`;
                        })
                        .catch(err => {
                            document.getElementById('scan-result-container').innerHTML =
                                `<p class="text-sm text-red-600 font-semibold">${err.message || '⚠️ Terjadi kesalahan server.'}</p>`;
                        });
                }

                document.getElementById("start-scan").addEventListener("click", () => {
                    const day = document.getElementById("scan-day-select").value;
                    if (!day) {
                        alert("Silakan pilih hari event terlebih dahulu!");
                        return;
                    }

                    html5QrCode = new Html5Qrcode("reader");
                    html5QrCode.start({
                            facingMode: "environment"
                        }, {
                            fps: 10,
                            qrbox: 250
                        },
                        onScanSuccess
                    ).then(() => {
                        document.getElementById("start-scan").classList.add("hidden");
                        document.getElementById("stop-scan").classList.remove("hidden");
                        document.getElementById('scan-result-container').innerHTML =
                            `<p class="text-sm text-gray-500">Arahkan QR code peserta ke kamera.</p>`;
                    });
                });

                document.getElementById("stop-scan").addEventListener("click", () => {
                    if (html5QrCode) {
                        html5QrCode.stop().then(() => {
                            html5QrCode.clear();
                            document.getElementById("stop-scan").classList.add("hidden");
                            document.getElementById("start-scan").classList.remove("hidden");
                            document.getElementById("scan-result-container").innerHTML =
                                `<p class="text-sm text-gray-500">Scan dihentikan. Pilih hari lalu klik "Mulai Scan" untuk memulai lagi.</p>`;
                        });
                    }
                });
            </script>

            {{-- End Scan barcode --}}

            <div id="absen-massal" class="tab-content hidden">
                <h3 class="font-bold text-lg mb-2">Absen Massal (Live Search)</h3>
                <p class="text-gray-500 mb-4">Pilih beberapa peserta sekaligus untuk melakukan presensi.</p>
                <form action="{{ route('admin.attendance.mass_store') }}" method="POST">
                    @csrf
                    <div class="p-4 border rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="text-sm font-medium">Pencarian Peserta</label>
                                <input type="search" id="mass-search-input" placeholder="Nama, token, HP, kabupaten..."
                                    class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label class="text-sm font-medium">Hari Event</label>
                                <select name="day" id="mass-day-select"
                                    class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                                    <option value="1">Hari 1</option>
                                    <option value="2">Hari 2</option>
                                    <option value="3">Hari 3</option>
                                </select>
                            </div>
                            <button type="submit" id="mass-submit-btn"
                                class="self-end px-6 py-2 bg-gray-400 text-white rounded-lg font-semibold h-10.5 disabled:opacity-50"
                                disabled>
                                <i class="fa-solid fa-save mr-2"></i>Simpan (0)
                            </button>
                        </div>
                        <div id="mass-attendees-container" class="border-t pt-4">
                            <div class="mb-2"><input type="checkbox" id="check-all-mass" class="rounded"><label
                                    for="check-all-mass" class="ml-2 font-medium">Pilih Semua</label></div>
                            <div id="mass-attendees-list" class="max-h-64 overflow-y-auto space-y-2">
                                <p class="text-center text-gray-400 py-4">Mulai mencari peserta atau ganti hari...</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Data Kehadiran --}}
            <div id="data-kehadiran" class="tab-content hidden">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Log Data Kehadiran</h3>
                    <form method="GET" action="{{ url()->current() }}" id="filter-log-form">
                        <input type="hidden" name="tab" value="data-kehadiran">
                        <select name="filter_log_day" onchange="document.getElementById('filter-log-form').submit()"
                            class="border-gray-300 rounded-lg shadow-sm">
                            <option value="all" {{ request('filter_log_day', 'all') == 'all' ? 'selected' : '' }}>
                                Semua Hari</option>
                            <option value="1" {{ request('filter_log_day') == 1 ? 'selected' : '' }}>Hari 1
                            </option>
                            <option value="2" {{ request('filter_log_day') == 2 ? 'selected' : '' }}>Hari 2
                            </option>
                            <option value="3" {{ request('filter_log_day') == 3 ? 'selected' : '' }}>Hari 3
                            </option>
                        </select>
                    </form>
                </div>
                <div class="space-y-3">
                    @forelse($attendanceLogs as $log)
                        <div class="p-3 border rounded flex flex-wrap justify-between items-center gap-4">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="font-semibold">{{ $log->attendee->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $log->attendee->token }} &bull;
                                        {{ $log->attendee->phone_number }}</p>
                                </div>
                            </div>
                            <div><span
                                    class="text-xs font-semibold bg-gray-800 text-white px-2 py-1 rounded-full mr-4">Hari
                                    {{ $log->day }}</span><span
                                    class="text-sm text-gray-500">{{ $log->created_at->format('d/m/Y, H:i') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-8">Belum ada data kehadiran yang cocok dengan filter.
                        </p>
                    @endforelse
                </div>
                <div class="mt-6">{{ $attendanceLogs->links() }}</div>
            </div>

            <div id="analisis" class="tab-content hidden">
                <h3 class="font-bold text-lg mb-4">Ringkasan Kehadiran Harian</h3>
                <div class="space-y-6">
                    @for ($i = 1; $i <= 3; $i++)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="font-semibold">Hari {{ $i }}</h4>
                                <span class="text-sm text-gray-600">{{ $dailyAttendance[$i] ?? 0 }} dari
                                    {{ $totalAttendees }}
                                    ({{ $totalAttendees > 0 ? number_format((($dailyAttendance[$i] ?? 0) / $totalAttendees) * 100, 0) : 0 }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-teal-500 h-4 rounded-full"
                                    style="width: {{ $totalAttendees > 0 ? (($dailyAttendance[$i] ?? 0) / $totalAttendees) * 100 : 0 }}%">
                                </div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Hadir: {{ $dailyAttendance[$i] ?? 0 }}</span>
                                <span>Tidak Hadir: {{ $totalAttendees - ($dailyAttendance[$i] ?? 0) }}</span>
                            </div>

                            <a href="{{ route('admin.export.attendance.analysis', ['day' => $i]) }}"
                                class="text-xs text-blue-600 hover:underline mt-2 inline-block">
                                <i class="fa-solid fa-download mr-1"></i>Export Analisis Wilayah Hari
                                {{ $i }}
                            </a>
                        </div>
                    @endfor
                </div>

                <hr class="my-8">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg">Analisis Demografi Kehadiran</h3>
                    <form method="GET" action="{{ url()->current() }}" id="analysis-form">
                        <input type="hidden" name="tab" value="analisis">
                        <select name="analysis_day" onchange="document.getElementById('analysis-form').submit()"
                            class="border-gray-300 rounded-lg shadow-sm">
                            <option value="all" {{ $analysisDay == 'all' ? 'selected' : '' }}>Semua Hari</option>
                            <option value="1" {{ $analysisDay == 1 ? 'selected' : '' }}>Hari 1</option>
                            <option value="2" {{ $analysisDay == 2 ? 'selected' : '' }}>Hari 2</option>
                            <option value="3" {{ $analysisDay == 3 ? 'selected' : '' }}>Hari 3</option>
                        </select>
                    </form>
                </div>
                @if (collect($regencyDistribution['data'])->sum() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h4 class="font-semibold text-center mb-4">Berdasarkan Wilayah</h4>
                            <div class="relative mx-auto" style="max-width: 350px; max-height: 350px;">
                                <canvas id="regencyChart"></canvas>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-center mb-4">Berdasarkan Usia</h4>
                            <div class="relative mx-auto" style="max-width: 350px; max-height: 350px;">
                                <canvas id="ageChart"></canvas>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <i class="fa-solid fa-chart-simple fa-3x mb-4"></i>
                        <p>Tidak ada data kehadiran yang cukup untuk ditampilkan pada periode ini.</p>
                    </div>
                @endif
            </div>

            <div id="laporan" class="tab-content hidden">
                <h3 class="font-bold text-lg mb-4">Laporan & Ekspor</h3>
                <p class="text-gray-500 mb-6">Download berbagai laporan data dalam format Excel.</p>

                <div class="border-t pt-6">
                    <h4 class="font-semibold mb-3">Ekspor Laporan Kehadiran per Hari</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.export.attendance.by_day', ['day' => 1]) }}"
                            class="block p-6 bg-teal-50 border border-teal-200 rounded-lg hover:bg-teal-100 text-teal-800 transition text-center">
                            <i class="fa-solid fa-file-excel fa-2x mb-3"></i>
                            <p class="font-semibold">Laporan Hari 1</p>
                            <p class="text-sm opacity-80">Download data kehadiran</p>
                        </a>
                        <a href="{{ route('admin.export.attendance.by_day', ['day' => 2]) }}"
                            class="block p-6 bg-teal-50 border border-teal-200 rounded-lg hover:bg-teal-100 text-teal-800 transition text-center">
                            <i class="fa-solid fa-file-excel fa-2x mb-3"></i>
                            <p class="font-semibold">Laporan Hari 2</p>
                            <p class="text-sm opacity-80">Download data kehadiran</p>
                        </a>
                        <a href="{{ route('admin.export.attendance.by_day', ['day' => 3]) }}"
                            class="block p-6 bg-teal-50 border border-teal-200 rounded-lg hover:bg-teal-100 text-teal-800 transition text-center">
                            <i class="fa-solid fa-file-excel fa-2x mb-3"></i>
                            <p class="font-semibold">Laporan Hari 3</p>
                            <p class="text-sm opacity-80">Download data kehadiran</p>
                        </a>
                    </div>
                </div>

                <hr class="my-8">

                <div class="">
                    <h4 class="font-semibold mb-3">Ekspor Laporan Peserta</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.export.users.complete') }}"
                            class="block p-6 bg-gray-50 border rounded-lg hover:bg-gray-100 text-center transition">
                            <i class="fa-solid fa-users fa-2x mb-3"></i>
                            <p class="font-semibold">Data Lengkap Peserta</p>
                            <p class="text-sm opacity-80">Semua yang terdaftar</p>
                        </a>
                        <a href="{{ route('admin.export.users.demographics') }}"
                            class="block p-6 bg-gray-50 border rounded-lg hover:bg-gray-100 text-center transition">
                            <i class="fa-solid fa-map-location-dot fa-2x mb-3"></i>
                            <p class="font-semibold">Data Demografi</p>
                            <p class="text-sm opacity-80">Peserta per wilayah</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Logika Tabs
                const tabs = document.querySelectorAll('.tab-link');
                const contents = document.querySelectorAll('.tab-content');
                tabs.forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href').substring(1);
                        contents.forEach(content => content.id === targetId ? content.classList.remove(
                            'hidden') : content.classList.add('hidden'));
                        tabs.forEach(t => {
                            t.classList.remove('border-teal-500', 'text-teal-600');
                            t.classList.add('border-transparent', 'text-gray-500');
                        });
                        this.classList.add('border-teal-500', 'text-teal-600');
                    });
                });

                // ===== MULAI: KODE BARU UNTUK LIVE SEARCH ABSEN MASSAL =====
                const massSearchInput = document.getElementById('mass-search-input');
                const massDaySelect = document.getElementById('mass-day-select');
                const massAttendeesList = document.getElementById('mass-attendees-list');
                const checkAllMass = document.getElementById('check-all-mass');
                const massSubmitBtn = document.getElementById('mass-submit-btn');
                let massSearchTimeout;

                const fetchMassAttendees = async () => {
                    const day = massDaySelect.value;
                    const search = massSearchInput.value.trim();

                    massAttendeesList.innerHTML =
                        `<p class="text-center text-gray-500 py-4"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Memuat peserta...</p>`;

                    try {
                        const response = await fetch(
                            `{{ route('admin.attendance.findForMassAbsen') }}?day=${day}&search=${search}`);
                        const attendees = await response.json();
                        renderMassAttendees(attendees);
                    } catch (error) {
                        massAttendeesList.innerHTML =
                            `<p class="text-center text-red-500 py-4">Gagal memuat data.</p>`;
                    }
                };

                function renderMassAttendees(attendees) {
                    massAttendeesList.innerHTML = ''; // Kosongkan list
                    if (attendees.length === 0) {
                        massAttendeesList.innerHTML =
                            `<p class="text-center text-gray-400 py-4">Tidak ada peserta yang bisa dipilih.</p>`;
                        return;
                    }

                    attendees.forEach(attendee => {
                        const nameParts = attendee.name.split(' ');
                        const initials = nameParts.length > 1 ?
                            `${nameParts[0].charAt(0)}${nameParts[1].charAt(0)}` :
                            attendee.name.charAt(0);

                        const row = document.createElement('div');
                        row.className = 'p-2 border rounded flex items-center';
                        row.innerHTML = `
                    <input type="checkbox" name="attendee_ids[]" value="${attendee.id}" class="rounded mass-checkbox mr-3">
                    <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center font-bold text-sm flex-shrink-0">${initials}</div>
                    <div class="ml-3">
                        <p class="font-semibold text-sm">${attendee.name} <span class="text-xs font-mono text-gray-500">${attendee.token}</span></p>
                        <p class="text-xs text-gray-500">${attendee.regency}</p>
                    </div>
                `;
                        massAttendeesList.appendChild(row);
                    });
                }

                function updateMassSubmitButton() {
                    const checkedCount = document.querySelectorAll('.mass-checkbox:checked').length;
                    massSubmitBtn.innerHTML = `<i class="fa-solid fa-save mr-2"></i>Simpan (${checkedCount})`;
                    if (checkedCount > 0) {
                        massSubmitBtn.disabled = false;
                        massSubmitBtn.classList.remove('bg-gray-400');
                        massSubmitBtn.classList.add('bg-gray-800');
                    } else {
                        massSubmitBtn.disabled = true;
                        massSubmitBtn.classList.add('bg-gray-400');
                        massSubmitBtn.classList.remove('bg-gray-800');
                    }
                }

                massSearchInput.addEventListener('input', debounce(fetchMassAttendees, 500));
                massDaySelect.addEventListener('change', fetchMassAttendees);

                checkAllMass.addEventListener('change', function() {
                    document.querySelectorAll('.mass-checkbox').forEach(cb => cb.checked = this.checked);
                    updateMassSubmitButton();
                });

                // Event delegation untuk checkbox individual
                massAttendeesList.addEventListener('change', function(e) {
                    if (e.target.classList.contains('mass-checkbox')) {
                        updateMassSubmitButton();
                    }
                });

                // Muat data awal saat halaman pertama kali dibuka
                fetchMassAttendees();
                // ===== SELESAI: KODE BARU UNTUK LIVE SEARCH ABSEN MASSAL =====

                // ===== MULAI: KODE LIVE SEARCH TOKEN YANG DISEMPURNAKAN =====
                const tokenInput = document.getElementById('token-search-input');
                const daySelect = document.getElementById('day-select');
                const resultContainer = document.getElementById('search-result-container');
                let searchTimeout;

                function debounce(func, delay = 400) {
                    return function(...args) {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            func.apply(this, args);
                        }, delay);
                    };
                }

                const searchAttendee = async () => {
                    const token = tokenInput.value.trim();
                    const day = daySelect.value;

                    if (token.length < 3) {
                        resultContainer.innerHTML =
                            '<p class="text-sm text-gray-500">Ketik minimal 3 karakter token untuk memulai pencarian.</p>';
                        return;
                    }

                    resultContainer.innerHTML = `
                <div class="flex items-center space-x-2 text-gray-500">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span>Mencari...</span>
                </div>
            `;

                    try {
                        const response = await fetch(
                            `{{ route('admin.attendance.findByToken') }}?token=${token}&day=${day}`);
                        const data = await response.json();

                        if (!response.ok) {
                            resultContainer.innerHTML = `
                        <div class="text-red-600 flex items-center space-x-2">
                            <i class="fa-solid fa-xmark-circle"></i>
                            <span>${data.message || 'Peserta tidak ditemukan.'}</span>
                        </div>
                    `;
                            return;
                        }

                        renderResult(data.attendee, data.is_present, day);

                    } catch (error) {
                        resultContainer.innerHTML =
                            '<p class="text-sm text-red-500">Terjadi kesalahan saat mencari.</p>';
                    }
                };

                function renderResult(attendee, isPresent, day) {
                    const buttonDisabled = isPresent ? 'disabled' : '';
                    const buttonText = isPresent ? 'Sudah Hadir' : 'Tandai Hadir';
                    const buttonClasses = isPresent ?
                        'bg-green-600 text-white cursor-not-allowed' :
                        'bg-gray-800 text-white hover:bg-gray-700';

                    resultContainer.innerHTML = `
                <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between w-full">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                            ${attendee.name.charAt(0)}${attendee.name.split(' ').length > 1 ? attendee.name.split(' ')[1].charAt(0) : ''}
                        </div>
                        <div class="ml-3">
                            <p class="font-bold text-gray-800">${attendee.name}</p>
                            <p class="text-xs text-gray-500">${attendee.token} &bull; ${attendee.phone_number}</p>
                        </div>
                    </div>
                    <button 
                        onclick="markAsPresent(this, '${attendee.token}', ${day})" 
                        class="px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-200 ${buttonClasses}"
                        ${buttonDisabled}>
                        <i class="fa-solid fa-user-check mr-2"></i> ${buttonText}
                    </button>
                </div>
            `;
                }

                window.markAsPresent = async (buttonElement, token, day) => {
                    buttonElement.disabled = true;
                    buttonElement.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...';

                    try {
                        const response = await fetch(`{{ route('admin.attendance.storeAjax') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                token: token,
                                day: day
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            alert(`Error: ${data.message}`);
                            searchAttendee();
                            return;
                        }

                        buttonElement.classList.remove('bg-gray-800', 'hover:bg-gray-700');
                        buttonElement.classList.add('bg-green-600', 'cursor-not-allowed');
                        buttonElement.innerHTML = '<i class="fa-solid fa-user-check mr-2"></i> Sudah Hadir';

                        updateStatCards(day);

                    } catch (error) {
                        alert('Terjadi kesalahan jaringan.');
                        searchAttendee();
                    }
                };

                function updateStatCards(day) {
                    const card = document.getElementById(`hadir-hari-${day}`);
                    if (card) {
                        let currentCount = parseInt(card.textContent);
                        card.textContent = currentCount + 1;
                        card.closest('.bg-white').classList.add('transform', 'scale-105', 'bg-green-50',
                            'transition-all', 'duration-300');
                        setTimeout(() => {
                            card.closest('.bg-white').classList.remove('transform', 'scale-105', 'bg-green-50');
                        }, 1500);
                    }
                }

                if (tokenInput) {
                    tokenInput.addEventListener('input', debounce(searchAttendee, 400));
                }
                if (daySelect) {
                    daySelect.addEventListener('change', searchAttendee);
                }
                // ===== SELESAI: KODE LIVE SEARCH TOKEN YANG DISEMPURNAKAN =====

                // ===== MULAI: KODE BARU UNTUK CHART DENGAN PERSENTASE =====
                const regencyCtx = document.getElementById('regencyChart');
                const ageCtx = document.getElementById('ageChart');

                const regencyData = {!! json_encode($regencyDistribution) !!};
                const ageData = {!! json_encode($ageDistribution) !!};

                // Fungsi untuk menghitung total dari array data
                const getTotal = (data) => data.reduce((sum, current) => sum + current, 0);

                if (regencyCtx && regencyData.data.length > 0) {
                    new Chart(regencyCtx, {
                        type: 'pie',
                        data: {
                            labels: regencyData.labels,
                            datasets: [{
                                label: 'Peserta',
                                data: regencyData.data,
                                backgroundColor: ['#34D399', '#60A5FA', '#FBBF24', '#F87171', '#93C5FD',
                                    '#A78BFA'
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                datalabels: { // Konfigurasi plugin datalabels
                                    formatter: (value, ctx) => {
                                        const total = getTotal(ctx.chart.data.datasets[0].data);
                                        const percentage = total > 0 ? (value / total * 100).toFixed(1) +
                                            '%' : '0%';
                                        return percentage;
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels] // Daftarkan plugin
                    });
                }

                if (ageCtx && ageData.data.length > 0) {
                    new Chart(ageCtx, {
                        type: 'pie',
                        data: {
                            labels: ageData.labels,
                            datasets: [{
                                label: 'Peserta',
                                data: ageData.data,
                                backgroundColor: ['#60A5FA', '#A78BFA', '#FBBF24', '#34D399', '#F87171',
                                    '#93C5FD'
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                datalabels: { // Konfigurasi plugin datalabels
                                    formatter: (value, ctx) => {
                                        const total = getTotal(ctx.chart.data.datasets[0].data);
                                        const percentage = total > 0 ? (value / total * 100).toFixed(1) +
                                            '%' : '0%';
                                        return percentage;
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels] // Daftarkan plugin
                    });
                }
                // ===== SELESAI: KODE BARU UNTUK CHART DENGAN PERSENTASE =====
            });
        </script>
    @endpush
</x-admin-layout>
