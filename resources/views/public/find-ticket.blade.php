{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Event - Muhammadiyah Jogja Expo 2025</title>
    
    <link rel="icon" href="{{ asset('mjelogo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .modal-enter { opacity: 0; transform: scale(0.95); }
        .modal-leave-to { opacity: 0; transform: scale(0.95); }
        .modal-enter-active, .modal-leave-active { transition: all 0.3s ease; }
        
        .hero-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z' fill='%23ffffff'%3E%3C/path%3E%3C/svg%3E") bottom;
            background-size: cover;
            opacity: 0.1;
        }
        
        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(14, 165, 233, 0.2);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-left: 4px solid;
        }
        
        .schedule-day {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border-left: 4px solid #0ea5e9;
        }
        
        .event-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transition: all 0.3s ease;
        }
        
        .event-card:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateX(10px);
        }
        
        .tenant-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(14, 165, 233, 0.1);
        }
        
        .cta-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
        }
        
        .wave-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.5), transparent);
            position: relative;
        }
        
        .wave-divider::before {
            content: "";
            position: absolute;
            top: -5px;
            left: 0;
            right: 0;
            height: 10px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z' fill='%230ea5e9'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-repeat: no-repeat;
            opacity: 0.2;
        }
        
        .logo-text {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .footer-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .footer-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #0ea5e9, #f59e0b);
            transition: width 0.3s ease;
        }
        
        .footer-link:hover::after {
            width: 100%;
        }
        
        .social-icon {
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        
        .newsletter-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .newsletter-input:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.3);
        }
        
        .subscribe-btn {
            background: linear-gradient(90deg, #0ea5e9, #0284c7);
            transition: all 0.3s ease;
        }
        
        .subscribe-btn:hover {
            background: linear-gradient(90deg, #0284c7, #0ea5e9);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .event-time {
            background: rgba(14, 165, 233, 0.1);
            border-left: 3px solid #0ea5e9;
        }
        
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .back-to-top.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .back-to-top:hover {
            transform: translateY(-5px);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translatey(0px); }
            50% { transform: translatey(-20px); }
            100% { transform: translatey(0px); }
        }
        
        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="antialiased">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <header class="flex justify-between items-center py-6 relative z-10">
            <div class="flex items-center space-x-3">
                <div class="p-3 rounded-xl shadow-md">
                    <img src="{{ asset('mjelogo.png') }}" alt="MJELogo" class="w-6 h-6 object-contain">
                </div>
                <a href="{{ route('home') }}" class="font-bold text-xl">
                    <span class="logo-text">Muhammadiyah</span><br>
                    <span class="text-amber-500">Jogja Expo 2025</span>
                </a>
            </div>
            
            <nav class="hidden md:flex items-center space-x-6 text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-house mr-2"></i>Beranda</a>
                <a href="{{ route('event.register.form') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-calendar-check mr-2"></i>Pendaftaran</a>
                <a href="{{ route('ticket.find') }}" class="bg-gray-900 text-white px-5 py-3 rounded-xl font-semibold shadow-lg hover:bg-gray-800 transition-all duration-300"><i class="fa-solid fa-print mr-2"></i>Cetak Tiket</a>
                <a href="{{ route('lottery.check') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-ticket mr-2"></i>Cek Undian</a>
            </nav>
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('login') }}" class="px-6 py-3 border-2 border-sky-500 text-sky-600 rounded-xl font-semibold hover:bg-sky-500 hover:text-white transition-all duration-300">Portal Tenan</a>
            </div>
            
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-800 hover:text-sky-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
            </header>

        <div id="mobile-menu" class="hidden md:hidden bg-white rounded-2xl shadow-lg mt-2 absolute top-24 left-4 right-4 z-20">
            <nav class="flex flex-col p-6 space-y-5">
                <a href="{{ route('home') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-house fa-fw mr-3"></i>Beranda</a>
                <a href="{{ route('event.register.form') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-calendar-check fa-fw mr-3"></i>Pendaftaran</a>
                 <a href="{{ route('ticket.find') }}" class="text-gray-700 bg-sky-50 text-sky-600 font-semibold px-4 py-3 rounded-lg"><i class="fa-solid fa-print fa-fw mr-3"></i>Cetak Tiket</a>
                <a href="{{ route('lottery.check') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-ticket fa-fw mr-3"></i>Cek Undian</a>
                <hr class="border-gray-200 my-3">
                <a href="{{ route('login') }}" class="w-full text-center px-6 py-3 border-2 border-sky-500 text-sky-600 rounded-xl font-semibold hover:bg-sky-500 hover:text-white transition-all duration-300">Portal Tenan</a>
            </nav>
        </div>
         <main class="my-12">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-bold text-gray-800 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-print text-sky-500"></i>
                        Cetak Ulang Tiket
                    </h1>
                    <p class="text-lg text-gray-600 mt-2">
                        Masukkan token, nomor HP, atau nama Anda untuk menemukan tiket.
                    </p>
                </div>

                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2 mb-5">
                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                        Cari Data Peserta
                    </h2>

                    <div class="grid grid-cols-3 text-center font-semibold border-b mb-5">
                        <button data-tab="token" class="tab-button py-3 px-4 border-b-2">
                            <i class="fa-solid fa-ticket mr-2 opacity-80"></i><span class="hidden sm:inline">Cari dengan</span> Token
                        </button>
                        <button data-tab="hp" class="tab-button py-3 px-4 border-b-2">
                            <i class="fa-solid fa-phone mr-2 opacity-80"></i><span class="hidden sm:inline">Cari dengan</span> No. HP
                        </button>
                         <button data-tab="nama" class="tab-button py-3 px-4 border-b-2">
                            <i class="fa-solid fa-user mr-2 opacity-80"></i><span class="hidden sm:inline">Cari dengan</span> Nama
                        </button>
                    </div>

                    <div>
                        <form id="token" data-tab-content method="GET" action="{{ route('ticket.find') }}">
                            <label for="token_query" class="block text-sm font-medium text-gray-700 mb-1">Nomor Token</label>
                            <div class="flex">
                                <input type="text" name="token_query" id="token_query" value="{{ $search_type === 'token' ? ($query ?? '') : '' }}" placeholder="Contoh: MJE-0000001" class="flex-grow w-full px-4 py-3 border border-gray-300 rounded-l-lg shadow-sm focus:ring-sky-500 focus:border-sky-500 text-base">
                                <button type="submit" class="bg-gray-800 text-white font-bold py-3 px-5 rounded-r-lg hover:bg-gray-700 transition-all">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <form id="hp" data-tab-content method="GET" action="{{ route('ticket.find') }}">
                             <label for="hp_query" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                            <div class="flex">
                                <input type="tel" name="hp_query" id="hp_query" value="{{ $search_type === 'hp' ? ($query ?? '') : '' }}" placeholder="Contoh: 08123456789" class="flex-grow w-full px-4 py-3 border border-gray-300 rounded-l-lg shadow-sm focus:ring-sky-500 focus:border-sky-500 text-base">
                                <button type="submit" class="bg-gray-800 text-white font-bold py-3 px-5 rounded-r-lg hover:bg-gray-700 transition-all">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <form id="nama" data-tab-content method="GET" action="{{ route('ticket.find') }}">
                            <label for="nama_query" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <div class="flex">
                                <input type="text" name="nama_query" id="nama_query" value="{{ $search_type === 'nama' ? ($query ?? '') : '' }}" placeholder="Masukkan nama lengkap Anda..." class="flex-grow w-full px-4 py-3 border border-gray-300 rounded-l-lg shadow-sm focus:ring-sky-500 focus:border-sky-500 text-base">
                                <button type="submit" class="bg-gray-800 text-white font-bold py-3 px-5 rounded-r-lg hover:bg-gray-700 transition-all">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if (isset($query) && !empty($query))
                <div class="mt-10">
                    @if ($attendees->isNotEmpty())
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Hasil pencarian untuk "<span class="text-sky-600">{{ $query }}</span>":</h3>
                        <div class="space-y-4">
                            @foreach ($attendees as $attendee)
                            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-user-check text-2xl text-green-500"></i>
                                    <div>
                                        <p class="font-bold text-lg text-gray-800">{{ $attendee->name }}</p>
                                        <p class="text-sm text-gray-500">Token: <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $attendee->token }}</span></p>
                                    </div>
                                </div>
                                <a href="{{ route('ticket.download', $attendee->token) }}" class="w-full sm:w-auto text-center bg-sky-500 text-white font-bold py-2 px-5 rounded-lg hover:bg-sky-600 transition-all duration-300 whitespace-nowrap">
                                    <i class="fa-solid fa-download mr-2"></i> Unduh Tiket
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white text-center p-8 rounded-2xl shadow-lg border border-gray-200">
                             <i class="fa-solid fa-magnifying-glass-minus fa-3x text-amber-500 mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-800">Data Tidak Ditemukan</h3>
                            <p class="text-gray-600 mt-2">Peserta dengan data "<span class="font-semibold">{{ $query }}</span>" tidak ditemukan. Pastikan data yang Anda masukkan benar.</p>
                        </div>
                    @endif
                </div>
                @endif
                
                 <div class="mt-16 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Butuh Bantuan?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 max-w-2xl mx-auto">
                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-lg text-left">
                            <p class="font-bold text-lg flex items-center gap-2"><i class="fa-solid fa-user-plus text-sky-500"></i> Belum Terdaftar?</p>
                            <p class="text-gray-600 mt-1">Silakan daftar terlebih dahulu melalui halaman pendaftaran.</p>
                            <a href="{{ route('event.register.form') }}" class="text-sky-600 font-semibold mt-3 inline-block hover:underline">Ke Halaman Pendaftaran &rarr;</a>
                        </div>
                         <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-lg text-left">
                            <p class="font-bold text-lg flex items-center gap-2"><i class="fa-solid fa-headset text-sky-500"></i> Mengalami Kendala?</p>
                            <p class="text-gray-600 mt-1">Jika masih mengalami kendala, hubungi panitia kami.</p>
                            <p class="text-sky-600 font-semibold mt-3 inline-block">Call Center: +62 274 xxx xxxx</p>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        </div>

    <footer class="bg-gradient-to-b from-gray-900 to-slate-800 text-gray-300 mt-16 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1/2 opacity-5 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4yIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjwvZz48L2c+PC9zdmc+')]"></div>
        
        <div class="container mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 relative z-10">
            <div class="col-span-1 lg:col-span-2">
                <h3 class="font-extrabold text-3xl text-white mb-4">
                    <span class="logo-text">Muhammadiyah</span> <span class="text-amber-400">Jogja Expo 2025</span>
                </h3>
                <p class="text-gray-400 text-sm max-w-lg mb-6 leading-relaxed text-justify">
                    Event besar tahunan Muhammadiyah Yogyakarta yang menampilkan berbagai kegiatan, pameran, dan peluang bisnis. 
                    Kami mengundang Anda untuk menjelajahi inovasi, kreativitas, dan kolaborasi dalam semangat kemajuan dan keislaman.
                </p>
                
                <div class="mt-6">
                    <h5 class="font-semibold text-white mb-3">Berlangganan Newsletter Kami</h5>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="email" placeholder="Alamat email Anda" class="newsletter-input px-4 py-3 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-sky-500 flex-grow">
                        <button class="subscribe-btn px-5 py-3 rounded-lg font-medium text-white">Berlangganan</button>
                    </div>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold text-xl text-white mb-6 relative inline-block">
                    <span class="relative z-10">Hubungi Kami</span>
                    <span class="absolute bottom-0 left-0 w-full h-2 bg-amber-400 opacity-30 -z-0"></span>
                </h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start">
                        <div class="bg-sky-500 p-2 rounded-lg mr-3 shadow-md">
                            <i class="fa-solid fa-location-dot text-white text-sm"></i>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="footer-link hover:text-white transition-colors duration-300">Yogyakarta, Indonesia</a>
                    </li>
                    <li class="flex items-start">
                        <div class="bg-sky-500 p-2 rounded-lg mr-3 shadow-md">
                            <i class="fa-solid fa-phone text-white text-sm"></i>
                        </div>
                        <a href="tel:+62274xxxxxxxx" class="footer-link hover:text-white transition-colors duration-300">+62 274 xxx xxxx</a>
                    </li>
                    <li class="flex items-start">
                        <div class="bg-sky-500 p-2 rounded-lg mr-3 shadow-md">
                            <i class="fa-solid fa-envelope text-white text-sm"></i>
                        </div>
                        <a href="mailto:info@muhammadiyahjogja.org" class="footer-link hover:text-white transition-colors duration-300">info@muhammadiyahjogja.org</a>
                    </li>
                </ul>
                
                <h4 class="font-bold text-xl text-white mt-8 mb-4 relative inline-block">
                    <span class="relative z-10">Tautan Cepat</span>
                    <span class="absolute bottom-0 left-0 w-full h-2 bg-amber-400 opacity-30 -z-0"></span>
                </h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="footer-link hover:text-white">Tentang Acara</a></li>
                    <li><a href="#" class="footer-link hover:text-white">Pameran</a></li>
                    <li><a href="#" class="footer-link hover:text-white">Pendaftaran</a></li>
                    <li><a href="#" class="footer-link hover:text-white">Sponsor</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-xl text-white mb-6 relative inline-block">
                    <span class="relative z-10">Jadwal Acara</span>
                    <span class="absolute bottom-0 left-0 w-full h-2 bg-amber-400 opacity-30 -z-0"></span>
                </h4>
                <ul class="space-y-4 text-sm">
                    <li class="event-time p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Hari 1</span> 
                            <span class="font-bold text-amber-400">08:00 - 22:00</span>
                        </div>
                        <p class="text-xs mt-1 text-gray-400">Pembukaan & Seminar Utama</p>
                    </li>
                    <li class="event-time p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Hari 2</span> 
                            <span class="font-bold text-amber-400">08:00 - 22:00</span>
                        </div>
                        <p class="text-xs mt-1 text-gray-400">Workshop & Pameran</p>
                    </li>
                    <li class="event-time p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Hari 3</span> 
                            <span class="font-bold text-amber-400">08:00 - 22:00</span>
                        </div>
                        <p class="text-xs mt-1 text-gray-400">Networking & Penutupan</p>
                    </li>
                </ul>
                
                <div class="mt-8 bg-gray-800 p-4 rounded-lg border-l-4 border-amber-400">
                    <h5 class="font-semibold text-white mb-2">Unduh Brosur Acara</h5>
                    <p class="text-xs text-gray-400 mb-3">Dapatkan informasi lengkap tentang acara kami</p>
                    <button class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors duration-300 flex items-center justify-center">
                        <i class="fa-solid fa-download mr-2"></i> Unduh Brosur
                    </button>
                </div>
            </div>
        </div>

        <div class="wave-divider my-6"></div>

        <div class="border-t border-gray-800 py-8 px-6 text-center md:flex md:justify-between md:items-center container mx-auto">
            <p class="text-gray-500 text-sm mb-4 md:mb-0">© 2025 Muhammadiyah Jogja Expo. All rights reserved.</p>
            
            <div class="flex justify-center md:justify-end space-x-4 text-gray-400 text-xl">
                <a href="#" aria-label="Facebook" class="social-icon bg-blue-600 hover:text-white">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" aria-label="Instagram" class="social-icon bg-pink-600 hover:text-white">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" aria-label="Twitter" class="social-icon bg-blue-400 hover:text-white">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="#" aria-label="YouTube" class="social-icon bg-red-600 hover:text-white">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>
        
        <div id="backToTop" class="back-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const regencySelect = document.getElementById('regency_select');
            const otherRegencyWrapper = document.getElementById('other_regency_wrapper');
            const otherRegencyInput = document.getElementById('other_regency');
            const backToTopButton = document.getElementById('backToTop');

            // ===== START: Mobile Menu Toggle Functionality =====
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = mobileMenuButton.querySelector('i');

            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                if (mobileMenu.classList.contains('hidden')) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                } else {
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                }
            });
            // ===== END: Mobile Menu Toggle Functionality =====

            function toggleOtherRegency() {
                if (regencySelect.value === 'Lain-lain') {
                    otherRegencyWrapper.classList.remove('hidden');
                    otherRegencyInput.setAttribute('required', 'required');
                } else {
                    otherRegencyWrapper.classList.add('hidden');
                    otherRegencyInput.removeAttribute('required');
                    otherRegencyInput.value = '';
                }
            }
            toggleOtherRegency();
            regencySelect.addEventListener('change', toggleOtherRegency);


            // Add loading state to CTA buttons
            document.querySelectorAll('a[href*="register"], a[href*="download"]').forEach(button => {
                button.addEventListener('click', function() {
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-3"></i>Loading...';
                    
                    // Reset after 2 seconds (simulate loading)
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                    }, 2000);
                });
            });

            // Back to top button functionality
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                }
            });
            
            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cari & Cetak Tiket - Muhammadiyah Jogja Expo 2025</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('mjelogo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .modal-enter {
            opacity: 0;
            transform: scale(0.95);
        }

        .modal-leave-to {
            opacity: 0;
            transform: scale(0.95);
        }

        .modal-enter-active,
        .modal-leave-active {
            transition: all 0.3s ease;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z' fill='%23ffffff'%3E%3C/path%3E%3C/svg%3E") bottom;
            background-size: cover;
            opacity: 0.1;
        }

        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(14, 165, 233, 0.2);
        }

        .stats-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-left: 4px solid;
        }

        .schedule-day {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border-left: 4px solid #0ea5e9;
        }

        .event-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transition: all 0.3s ease;
        }

        .event-card:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateX(10px);
        }

        .tenant-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(14, 165, 233, 0.1);
        }

        .cta-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
        }

        .wave-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.5), transparent);
            position: relative;
        }

        .wave-divider::before {
            content: "";
            position: absolute;
            top: -5px;
            left: 0;
            right: 0;
            height: 10px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z' fill='%230ea5e9'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-repeat: no-repeat;
            opacity: 0.2;
        }

        .logo-text {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .footer-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .footer-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #0ea5e9, #f59e0b);
            transition: width 0.3s ease;
        }

        .footer-link:hover::after {
            width: 100%;
        }

        .social-icon {
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .newsletter-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .newsletter-input:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.3);
        }

        .subscribe-btn {
            background: linear-gradient(90deg, #0ea5e9, #0284c7);
            transition: all 0.3s ease;
        }

        .subscribe-btn:hover {
            background: linear-gradient(90deg, #0284c7, #0ea5e9);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .event-time {
            background: rgba(14, 165, 233, 0.1);
            border-left: 3px solid #0ea5e9;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .back-to-top.show {
            opacity: 1;
            transform: translateY(0);
        }

        .back-to-top:hover {
            transform: translateY(-5px);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translatey(0px);
            }

            50% {
                transform: translatey(-20px);
            }

            100% {
                transform: translatey(0px);
            }
        }

        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="antialiased">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <header class="flex justify-between items-center py-6 relative z-10">
            <div class="flex items-center space-x-3">
                <div class="p-3 rounded-xl shadow-md">
                    <img src="{{ asset('mjelogo.png') }}" alt="MJELogo" class="w-6 h-6 object-contain">
                </div>
                <a href="{{ route('home') }}" class="font-bold text-xl">
                    <span class="logo-text">Muhammadiyah</span><br>
                    <span class="text-amber-500">Jogja Expo 2025</span>
                </a>
            </div>

            <nav class="hidden md:flex items-center space-x-6 text-gray-600">
                <a href="{{ route('home') }}"
                    class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i
                        class="fa-solid fa-house mr-2"></i>Beranda</a>
                <a href="{{ route('event.register.form') }}"
                    class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i
                        class="fa-solid fa-calendar-check mr-2"></i>Pendaftaran</a>
                <a href="{{ route('ticket.find') }}"
                    class="bg-gray-900 text-white px-5 py-3 rounded-xl font-semibold shadow-lg hover:bg-gray-800 transition-all duration-300"><i
                        class="fa-solid fa-print mr-2"></i>Cetak Tiket</a>
                <a href="{{ route('lottery.check') }}"
                    class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i
                        class="fa-solid fa-ticket mr-2"></i>Cek Undian</a>
                <a href="{{ route('news.index') }}"
                    class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300">
                    <i class="fa-solid fa-newspaper fa-fw mr-3"></i>Portal Berita
                </a>

            </nav>
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('login') }}"
                    class="px-6 py-3 border-2 border-sky-500 text-sky-600 rounded-xl font-semibold hover:bg-sky-500 hover:text-white transition-all duration-300">Portal
                    Tenan</a>
            </div>

            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-800 hover:text-sky-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </header>

        <div id="mobile-menu"
            class="hidden md:hidden bg-white rounded-2xl shadow-lg mt-2 absolute top-24 left-4 right-4 z-20">
            <nav class="flex flex-col p-6 space-y-5">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i
                        class="fa-solid fa-house fa-fw mr-3"></i>Beranda</a>
                <a href="{{ route('event.register.form') }}"
                    class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i
                        class="fa-solid fa-calendar-check fa-fw mr-3"></i>Pendaftaran</a>
                <a href="{{ route('ticket.find') }}"
                    class="text-gray-700 bg-sky-50 text-sky-600 font-semibold px-4 py-3 rounded-lg"><i
                        class="fa-solid fa-print fa-fw mr-3"></i>Cetak Tiket</a>
                <a href="{{ route('lottery.check') }}"
                    class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i
                        class="fa-solid fa-ticket fa-fw mr-3"></i>Cek Undian</a>
                <a href="{{ route('news.index') }}"
                    class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300">
                    <i class="fa-solid fa-newspaper fa-fw mr-3"></i>Portal Berita
                </a>
                <hr class="border-gray-200 my-3">
                <a href="{{ route('login') }}"
                    class="w-full text-center px-6 py-3 border-2 border-sky-500 text-sky-600 rounded-xl font-semibold hover:bg-sky-500 hover:text-white transition-all duration-300">Portal
                    Tenan</a>
            </nav>
        </div>

        <main class="my-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h1
                        class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-print text-sky-500"></i> Tiket
                    </h1>
                    <p class="text-base sm:text-lg text-gray-600 mt-2 max-w-2xl mx-auto">
                        Masukkan token, nomor HP, atau nama Anda untuk mendownload tiket peserta.
                    </p>
                </div>

                {{-- Search Data Peserta --}}
                <div class="bg-white p-5 sm:p-8 rounded-2xl shadow-lg border border-gray-200">
                    <div class="sm:flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                                Cari Data Peserta
                            </h2>
                            <p class="text-gray-500 text-sm mt-1">Gunakan token, nomor HP, atau nama yang terdaftar.</p>
                        </div>

                        <!-- Tabs scroll di mobile -->
                        <div
                            class="flex-shrink-0 mt-4 sm:mt-0 p-1 bg-gray-100 rounded-xl flex space-x-1 overflow-x-auto justify-between">
                            <button data-tab="token"
                                class="tab-button py-2 px-4 sm:px-5 rounded-lg font-semibold text-sm whitespace-nowrap">
                                <i class="fa-solid fa-ticket mr-2 opacity-80"></i> Token
                            </button>
                            <button data-tab="hp"
                                class="tab-button py-2 px-4 sm:px-5 rounded-lg font-semibold text-sm whitespace-nowrap">
                                <i class="fa-solid fa-phone mr-2 opacity-80"></i> No. HP
                            </button>
                            <button data-tab="nama"
                                class="tab-button py-2 px-4 sm:px-5 rounded-lg font-semibold text-sm whitespace-nowrap">
                                <i class="fa-solid fa-user mr-2 opacity-80"></i> Nama
                            </button>
                        </div>
                    </div>

                    <!-- Form responsif -->
                    <div>
                        <form id="token" data-tab-content method="GET" action="{{ route('ticket.find') }}">
                            <label for="token_query" class="block text-sm font-medium text-gray-700 mb-2">Token
                                Peserta</label>
                            <div class="flex flex-col sm:flex-row">
                                <input type="text" name="token_query" id="token_query"
                                    value="{{ $search_type === 'token' ? $query ?? '' : '' }}"
                                    placeholder="Contoh: MJE123456"
                                    class="flex-grow w-full px-4 py-3 border border-gray-300 rounded-t-lg sm:rounded-l-lg sm:rounded-tr-none shadow-sm focus:ring-sky-500 focus:border-sky-500 text-base">
                                <button type="submit"
                                    class="bg-gray-800 text-white font-bold py-3 px-5 rounded-b-lg sm:rounded-r-lg sm:rounded-bl-none hover:bg-gray-700 transition-all">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Form HP -->
                        <form id="hp" data-tab-content method="GET" action="{{ route('ticket.find') }}">
                            <label for="hp_query" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                HP</label>
                            <div class="flex flex-col sm:flex-row">
                                <input type="tel" name="hp_query" id="hp_query"
                                    value="{{ $search_type === 'hp' ? $query ?? '' : '' }}"
                                    placeholder="Contoh: 081234567890"
                                    class="flex-grow w-full px-4 py-3 border border-gray-300 rounded-t-lg sm:rounded-l-lg sm:rounded-tr-none shadow-sm focus:ring-sky-500 focus:border-sky-500 text-base">
                                <button type="submit"
                                    class="bg-gray-800 text-white font-bold py-3 px-5 rounded-b-lg sm:rounded-r-lg sm:rounded-bl-none hover:bg-gray-700 transition-all">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Form Nama -->
                        <form id="nama" data-tab-content method="GET" action="{{ route('ticket.find') }}">
                            <label for="nama_query" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                Lengkap</label>
                            <div class="flex flex-col sm:flex-row">
                                <input type="text" name="nama_query" id="nama_query"
                                    value="{{ $search_type === 'nama' ? $query ?? '' : '' }}"
                                    placeholder="Masukkan nama lengkap Anda..."
                                    class="flex-grow w-full px-4 py-3 border border-gray-300 rounded-t-lg sm:rounded-l-lg sm:rounded-tr-none shadow-sm focus:ring-sky-500 focus:border-sky-500 text-base">
                                <button type="submit"
                                    class="bg-gray-800 text-white font-bold py-3 px-5 rounded-b-lg sm:rounded-r-lg sm:rounded-bl-none hover:bg-gray-700 transition-all">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Hasil pencarian -->
                @if (isset($query) && !empty($query))
                    <div class="mt-10">
                        @if ($attendees->isNotEmpty())
                            <h3 class="text-lg sm:text-xl font-semibold text-gray-700 mb-4">
                                Hasil pencarian untuk "<span class="text-sky-600">{{ $query }}</span>":
                            </h3>
                            <div class="space-y-4">
                                @foreach ($attendees as $attendee)
                                    <div
                                        class="bg-white p-5 sm:p-6 rounded-xl shadow-lg border border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                        <div class="flex items-center gap-3 sm:gap-4">
                                            <i class="fa-solid fa-user-check text-xl sm:text-2xl text-green-500"></i>
                                            <div>
                                                <p class="font-bold text-base sm:text-lg text-gray-800">
                                                    {{ $attendee->name }}</p>
                                                <p class="text-xs sm:text-sm text-gray-500">
                                                    Token: <span
                                                        class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $attendee->token }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('ticket.download', $attendee->token) }}"
                                            class="w-full sm:w-auto text-center bg-sky-500 text-white font-bold py-2 px-5 rounded-lg hover:bg-sky-600 transition-all duration-300 whitespace-nowrap">
                                            <i class="fa-solid fa-download mr-2"></i> Unduh Tiket
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white text-center p-8 rounded-2xl shadow-lg border border-gray-200">
                                <i class="fa-solid fa-magnifying-glass-minus fa-3x text-amber-500 mb-4"></i>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">Data Tidak Ditemukan</h3>
                                <p class="text-gray-600 mt-2">
                                    Peserta dengan data "<span class="font-semibold">{{ $query }}</span>" tidak
                                    ditemukan.
                                    Pastikan data yang Anda masukkan benar.
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Bantuan -->
                <div class="mt-16 text-center">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Butuh Bantuan?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 max-w-2xl mx-auto">
                        <div class="bg-white p-5 sm:p-6 rounded-xl border border-gray-200 shadow-lg text-left">
                            <p class="font-bold text-base sm:text-lg flex items-center gap-2">
                                <i class="fa-solid fa-user-plus text-sky-500"></i> Belum Terdaftar?
                            </p>
                            <p class="text-gray-600 mt-1 text-sm sm:text-base">
                                Silakan daftar terlebih dahulu melalui halaman pendaftaran.
                            </p>
                            <a href="{{ route('event.register.form') }}"
                                class="text-sky-600 font-semibold mt-3 inline-block hover:underline text-sm sm:text-base">
                                Ke Halaman Pendaftaran &rarr;
                            </a>
                        </div>
                        <div class="bg-white p-5 sm:p-6 rounded-xl border border-gray-200 shadow-lg text-left">
                            <p class="font-bold text-base sm:text-lg flex items-center gap-2">
                                <i class="fa-solid fa-headset text-sky-500"></i> Mengalami Kendala?
                            </p>
                            <p class="text-gray-600 mt-1 text-sm sm:text-base">
                                Jika masih mengalami kendala, hubungi panitia kami.
                            </p>
                            <p class="text-sky-600 font-semibold mt-3 inline-block text-sm sm:text-base">
                                Call Center: +62 274 xxx xxxx
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer class="bg-gradient-to-b from-gray-900 to-slate-800 text-gray-300 mt-16 relative overflow-hidden">
        <div
            class="absolute top-0 left-0 w-full h-1/2 opacity-5 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4yIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjwvZz48L2c+PC9zdmc+')]">
        </div>

        <div class="container mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 relative z-10">
            <div class="col-span-1 lg:col-span-2">
                <h3 class="font-extrabold text-3xl text-white mb-4">
                    <span class="logo-text">Muhammadiyah</span> <span class="text-amber-400">Jogja Expo 2025</span>
                </h3>
                <p class="text-gray-400 text-sm max-w-lg mb-6 leading-relaxed text-justify">
                    Event besar tahunan Muhammadiyah Yogyakarta yang menampilkan berbagai kegiatan, pameran, dan peluang
                    bisnis.
                    Kami mengundang Anda untuk menjelajahi inovasi, kreativitas, dan kolaborasi dalam semangat kemajuan
                    dan keislaman.
                </p>

                <div class="mt-6">
                    <h5 class="font-semibold text-white mb-3">Berlangganan Newsletter Kami</h5>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="email" placeholder="Alamat email Anda"
                            class="newsletter-input px-4 py-3 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-sky-500 flex-grow">
                        <button class="subscribe-btn px-5 py-3 rounded-lg font-medium text-white">Berlangganan</button>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-xl text-white mb-6 relative inline-block">
                    <span class="relative z-10">Hubungi Kami</span>
                    <span class="absolute bottom-0 left-0 w-full h-2 bg-amber-400 opacity-30 -z-0"></span>
                </h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start">
                        <div class="bg-sky-500 p-2 rounded-lg mr-3 shadow-md">
                            <i class="fa-solid fa-location-dot text-white text-sm"></i>
                        </div>
                        <a href="https://maps.google.com" target="_blank"
                            class="footer-link hover:text-white transition-colors duration-300">Yogyakarta,
                            Indonesia</a>
                    </li>
                    <li class="flex items-start">
                        <div class="bg-sky-500 p-2 rounded-lg mr-3 shadow-md">
                            <i class="fa-solid fa-phone text-white text-sm"></i>
                        </div>
                        <a href="tel:+62274xxxxxxxx"
                            class="footer-link hover:text-white transition-colors duration-300">+62 274 xxx xxxx</a>
                    </li>
                    <li class="flex items-start">
                        <div class="bg-sky-500 p-2 rounded-lg mr-3 shadow-md">
                            <i class="fa-solid fa-envelope text-white text-sm"></i>
                        </div>
                        <a href="mailto:info@muhammadiyahjogja.org"
                            class="footer-link hover:text-white transition-colors duration-300">info@muhammadiyahjogja.org</a>
                    </li>
                </ul>

                <h4 class="font-bold text-xl text-white mt-8 mb-4 relative inline-block">
                    <span class="relative z-10">Tautan Cepat</span>
                    <span class="absolute bottom-0 left-0 w-full h-2 bg-amber-400 opacity-30 -z-0"></span>
                </h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="footer-link hover:text-white">Tentang Acara</a></li>
                    <li><a href="#" class="footer-link hover:text-white">Pameran</a></li>
                    <li><a href="#" class="footer-link hover:text-white">Pendaftaran</a></li>
                    <li><a href="#" class="footer-link hover:text-white">Sponsor</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-xl text-white mb-6 relative inline-block">
                    <span class="relative z-10">Jadwal Acara</span>
                    <span class="absolute bottom-0 left-0 w-full h-2 bg-amber-400 opacity-30 -z-0"></span>
                </h4>
                <ul class="space-y-4 text-sm">
                    <li class="event-time p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Hari 1</span>
                            <span class="font-bold text-amber-400">08:00 - 22:00</span>
                        </div>
                        <p class="text-xs mt-1 text-gray-400">Pembukaan & Seminar Utama</p>
                    </li>
                    <li class="event-time p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Hari 2</span>
                            <span class="font-bold text-amber-400">08:00 - 22:00</span>
                        </div>
                        <p class="text-xs mt-1 text-gray-400">Workshop & Pameran</p>
                    </li>
                    <li class="event-time p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Hari 3</span>
                            <span class="font-bold text-amber-400">08:00 - 16:00</span>
                        </div>
                        <p class="text-xs mt-1 text-gray-400">Networking & Penutupan</p>
                    </li>
                </ul>

                <div class="mt-8 bg-gray-800 p-4 rounded-lg border-l-4 border-amber-400">
                    <h5 class="font-semibold text-white mb-2">Unduh Brosur Acara</h5>
                    <p class="text-xs text-gray-400 mb-3">Dapatkan informasi lengkap tentang acara kami</p>
                    <button
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors duration-300 flex items-center justify-center">
                        <i class="fa-solid fa-download mr-2"></i> Unduh Brosur
                    </button>
                </div>
            </div>
        </div>

        <div class="wave-divider my-6"></div>

        <div
            class="border-t border-gray-800 py-8 px-6 text-center md:flex md:justify-between md:items-center container mx-auto">
            <p class="text-gray-500 text-sm mb-4 md:mb-0">© 2025 Muhammadiyah Jogja Expo. All rights reserved.</p>

            <div class="flex justify-center md:justify-end space-x-4 text-gray-400 text-xl">
                <a href="#" aria-label="Facebook" class="social-icon bg-blue-600 hover:text-white">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" aria-label="Instagram" class="social-icon bg-pink-600 hover:text-white">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" aria-label="Twitter" class="social-icon bg-blue-400 hover:text-white">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="#" aria-label="YouTube" class="social-icon bg-red-600 hover:text-white">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>

        <div id="backToTop" class="back-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('[data-tab-content]');

            const activeClasses = ['bg-gray-800', 'text-white', 'shadow'];
            const inactiveClasses = ['text-gray-600', 'hover:bg-gray-200'];



            function activateTab(tabId) {
                tabs.forEach(tab => {
                    if (tab.dataset.tab === tabId) {
                        tab.classList.add(...activeClasses);
                        tab.classList.remove(...inactiveClasses);
                    } else {
                        tab.classList.add(...inactiveClasses);
                        tab.classList.remove(...activeClasses);
                    }
                });

                tabContents.forEach(content => {
                    content.classList.toggle('hidden', content.id !== tabId);
                });
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    activateTab(tab.dataset.tab);
                });
            });

            const initialTab = "{{ $search_type ?? 'token' }}";
            activateTab(initialTab);

            @if (isset($query) && !empty($query))
                document.getElementById(initialTab + '_query').focus();
            @endif


            const backToTopButton = document.getElementById('backToTop');

            // ===== START: Mobile Menu Toggle Functionality =====
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = mobileMenuButton.querySelector('i');

            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                if (mobileMenu.classList.contains('hidden')) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                } else {
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                }
            });
            // ===== END: Mobile Menu Toggle Functionality =====


            // Add loading state to CTA buttons
            document.querySelectorAll('a[href*="register"], a[href*="download"]').forEach(button => {
                button.addEventListener('click', function() {
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-3"></i>Loading...';

                    // Reset after 2 seconds (simulate loading)
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                    }, 2000);
                });
            });

            // Back to top button functionality
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                }
            });

            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
