<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muhammadiyah Jogja Expo 2025</title>

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
                <div class="bg-sky-500 p-3 rounded-xl shadow-lg floating-animation">
                    <i class="fa-solid fa-calendar-days text-white text-lg"></i>
                </div>
                <a href="{{ route('home') }}" class="font-bold text-xl">
                    <span class="logo-text">Muhammadiyah</span><br>
                    <span class="text-amber-500">Jogja Expo 2025</span>
                </a>
            </div>
            
            <nav class="hidden md:flex items-center space-x-6 text-gray-600">
                <a href="{{ route('home') }}" class="bg-gray-900 text-white px-5 py-3 rounded-xl font-semibold shadow-lg hover:bg-gray-800 transition-all duration-300"><i class="fa-solid fa-house mr-2"></i>Beranda</a>
                <a href="{{ route('event.register.form') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-calendar-check mr-2"></i>Pendaftaran</a>
                <a href="{{ route('ticket.find') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-print mr-2"></i>Cetak Tiket</a>
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
                <a href="{{ route('ticket.find') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-print fa-fw mr-3"></i>Cetak Tiket</a>
                <a href="{{ route('lottery.check') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-ticket fa-fw mr-3"></i>Cek Undian</a>
                <hr class="border-gray-200 my-3">
                <a href="{{ route('login') }}" class="w-full text-center px-6 py-3 border-2 border-sky-500 text-sky-600 rounded-xl font-semibold hover:bg-sky-500 hover:text-white transition-all duration-300">Portal Tenan</a>
            </nav>
        </div>
        <main>
            <section class="hero-gradient text-white rounded-3xl p-12 md:p-20 text-center my-8 shadow-2xl relative">
                <div class="relative z-10">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">Muhammadiyah<br><span class="text-amber-300">Jogja Expo 2025</span></h1>
                    <p class="mt-6 text-xl md:text-2xl opacity-90 max-w-3xl mx-auto">Event Tahunan Terbesar Muhammadiyah Yogyakarta</p>
                    <div class="mt-10">
                        <a href="{{ route('event.register.form') }}" class="bg-white text-sky-600 font-bold py-4 px-8 rounded-xl hover:bg-amber-50 hover:text-amber-600 transition-all duration-300 shadow-lg pulse-animation inline-flex items-center">
                            <i class="fa-solid fa-user-plus mr-3"></i>Daftar Sekarang
                        </a>
                    </div>
                </div>
            </section>
            
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 my-16">
                <div class="stats-card border-sky-500 p-8 rounded-2xl shadow-lg card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-4xl font-bold text-gray-800">{{ number_format($totalAttendees, 0, ',', '.') }}</p>
                            <p class="text-gray-600 mt-2 font-medium">Total Peserta Terdaftar</p>
                        </div>
                        <i class="fa-solid fa-users text-4xl text-sky-500"></i>
                    </div>
                </div>
                <div class="stats-card border-blue-500 p-8 rounded-2xl shadow-lg card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-4xl font-bold text-gray-800">{{ number_format($totalAttendance, 0, ',', '.') }}</p>
                            <p class="text-gray-600 mt-2 font-medium">Total Kehadiran</p>
                        </div>
                        <i class="fa-solid fa-calendar-day text-4xl text-blue-500"></i>
                    </div>
                </div>
                <div class="stats-card border-orange-500 p-8 rounded-2xl shadow-lg card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-4xl font-bold text-gray-800">{{ number_format($totalSales, 0, ',', '.') }}</p>
                            <p class="text-gray-600 mt-2 font-medium">Total Penjualan</p>
                        </div>
                        <i class="fa-solid fa-chart-line text-4xl text-orange-500"></i>
                    </div>
                </div>
                <div class="stats-card border-purple-500 p-8 rounded-2xl shadow-lg card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-4xl font-bold text-gray-800">3</p>
                            <p class="text-gray-600 mt-2 font-medium">Hari Event</p>
                        </div>
                        <i class="fa-solid fa-award text-4xl text-purple-500"></i>
                    </div>
                </div>
            </section>

            <section class="bg-white p-10 rounded-3xl shadow-xl my-16">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-4xl font-bold text-gray-800">Jadwal Acara</h2>
                    <span class="bg-gradient-to-r from-sky-100 to-blue-100 text-sky-700 font-semibold px-6 py-3 rounded-xl border border-sky-200">3 Hari Event</span>
                </div>
                <div class="space-y-10">
                    @for ($i = 1; $i <= 3; $i++)
                    @php $eventsThisDay = $eventsByDay->get($i, collect()); @endphp
                    <div class="schedule-day p-6 rounded-2xl">
                        <h3 class="text-2xl font-bold text-sky-600 mb-6 flex items-center">
                            <i class="fa-solid fa-calendar-day mr-3 text-3xl"></i>
                            Hari {{ $i }} - Event Day {{ $i }}
                        </h3>
                        @forelse($eventsThisDay->take(3) as $event)
                        <div class="event-card p-6 rounded-xl mb-4 border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-bold text-lg text-gray-800 mb-2">{{ $event->title }}</p>
                                    <p class="text-gray-600 mb-4">{{ $event->description }}</p>
                                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                                        <span class="flex items-center bg-white px-3 py-2 rounded-lg border">
                                            <i class="fa-regular fa-clock mr-2 text-sky-500"></i>
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                        </span>
                                        <span class="flex items-center bg-white px-3 py-2 rounded-lg border">
                                            <i class="fa-solid fa-location-dot mr-2 text-red-500"></i>
                                            {{ $event->location }}
                                        </span>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold bg-sky-500 text-white px-4 py-2 rounded-full ml-4">Hari {{ $i }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Jadwal untuk hari ke-{{$i}} akan segera diumumkan.</p>
                        </div>
                        @endforelse

                        @if($eventsThisDay->count() > 3)
                        <div class="text-center mt-6">
                            <button class="show-more-btn px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg" data-day="{{ $i }}" data-title="Rundown Lengkap Hari {{ $i }}">
                                Lihat Lebih Banyak <i class="fa-solid fa-chevron-down ml-2"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                    @endfor
                </div>
            </section>
            
            <section class="my-16">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Tenan Terlaris</h2>
                    <p class="text-xl text-gray-600">Tenan dengan performa terbaik di expo ini</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($topTenants as $category => $tenants)
                    <div class="tenant-card p-8 rounded-2xl shadow-lg card-hover">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold mb-2 capitalize flex items-center justify-center">
                                <i class="fa-solid fa-star text-amber-400 mr-3 text-2xl"></i>
                                {{ str_replace('_', ' ', $category) }}
                            </h3>
                            <p class="text-gray-500">Tenan dengan penjualan tertinggi</p>
                        </div>
                        <ul class="space-y-4">
                            @forelse($tenants as $index => $tenant)
                            <li class="flex justify-between items-center p-4 rounded-xl {{ $index == 0 ? 'bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-400' : ($index == 1 ? 'bg-gradient-to-r from-gray-50 to-slate-50 border-l-4 border-gray-400' : 'bg-gradient-to-r from-orange-50 to-red-50 border-l-4 border-orange-400') }}">
                                <div class="flex items-center">
                                    <span class="{{ $index == 0 ? 'bg-amber-400 text-white' : ($index == 1 ? 'bg-gray-400 text-white' : 'bg-orange-400 text-white') }} rounded-full w-8 h-8 inline-flex items-center justify-center mr-4 font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="font-semibold text-gray-800">{{ $tenant->tenant_name }}</span>
                                </div>
                                <span class="font-bold text-gray-700">{{ number_format($tenant->total_sales, 0, ',', '.') }}</span>
                            </li>
                            @empty
                            <li class="text-center py-6">
                                <i class="fa-solid fa-chart-line text-3xl text-gray-300 mb-2"></i>
                                <p class="text-gray-400">Belum ada data penjualan.</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    @endforeach
                </div>
            </section>

            <section class="cta-gradient text-white p-12 rounded-3xl shadow-2xl my-16 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-transparent to-black opacity-20"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-6">Bergabunglah dengan Event Terbesar Tahun Ini!</h2>
                    <p class="text-xl opacity-90 mb-8 max-w-3xl mx-auto leading-relaxed">
                        Daftarkan diri Anda sekarang untuk mendapatkan akses ke seluruh acara, kesempatan memenangkan doorprize menarik, dan pengalaman tak terlupakan.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <a href="{{ route('event.register.form') }}" class="bg-amber-500 hover:bg-amber-400 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 shadow-lg flex items-center">
                            <i class="fa-solid fa-calendar-check mr-3"></i>Daftar Event Gratis
                        </a>
                        <a href="#" class="bg-white hover:bg-gray-100 text-gray-900 font-bold py-4 px-8 rounded-xl transition-all duration-300 shadow-lg flex items-center">
                            <i class="fa-solid fa-download mr-3"></i>Download Tiket
                        </a>
                    </div>
                </div>
            </section>
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
                            <span class="font-bold text-amber-400">08:00 - 17:00</span>
                        </div>
                        <p class="text-xs mt-1 text-gray-400">Pembukaan & Seminar Utama</p>
                    </li>
                    <li class="event-time p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Hari 2</span> 
                            <span class="font-bold text-amber-400">08:00 - 17:00</span>
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

    <div id="scheduleModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl m-4 max-h-[90vh] overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b bg-gradient-to-r from-sky-500 to-blue-600 text-white">
                <h3 id="modal-title" class="text-2xl font-bold"></h3>
                <button id="close-modal-btn" class="text-white hover:text-gray-200 text-3xl transition-colors duration-300 w-10 h-10 flex items-center justify-center rounded-full hover:bg-white hover:bg-opacity-20">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div id="modal-body" class="p-6 max-h-[70vh] overflow-y-auto space-y-4"></div>
        </div>
    </div>

    <script>
        const allEvents = @json($eventsByDay);
        
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('scheduleModal');
            const modalTitle = document.getElementById('modal-title');
            const modalBody = document.getElementById('modal-body');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const showMoreBtns = document.querySelectorAll('.show-more-btn');
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

            function openModal(day, title) {
                modalTitle.textContent = title;
                modalBody.innerHTML = '';
                const eventsForDay = allEvents[day] || [];
                
                if (eventsForDay.length > 0) {
                    eventsForDay.forEach((event, index) => {
                        const eventCard = document.createElement('div');
                        eventCard.className = 'bg-gradient-to-r from-gray-50 to-slate-50 p-6 rounded-xl border-l-4 border-sky-500 hover:shadow-lg transition-all duration-300';
                        
                        const startTime = new Date(event.start_time).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                        const endTime = new Date(event.end_time).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                        
                        eventCard.innerHTML = `
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <span class="bg-sky-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">
                                            ${index + 1}
                                        </span>
                                        <p class="font-bold text-lg text-gray-800">${event.title}</p>
                                    </div>
                                    <p class="text-gray-600 mb-4 ml-11">${event.description}</p>
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 ml-11">
                                        <span class="flex items-center bg-white px-3 py-2 rounded-lg border shadow-sm">
                                            <i class="fa-regular fa-clock mr-2 text-sky-500"></i>
                                            ${startTime} - ${endTime}
                                        </span>
                                        <span class="flex items-center bg-white px-3 py-2 rounded-lg border shadow-sm">
                                            <i class="fa-solid fa-location-dot mr-2 text-red-500"></i>
                                            ${event.location}
                                        </span>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold bg-sky-500 text-white px-4 py-2 rounded-full ml-4 shrink-0">
                                    Hari ${day}
                                </span>
                            </div>
                        `;
                        modalBody.appendChild(eventCard);
                    });
                } else {
                    modalBody.innerHTML = `
                        <div class="text-center py-12">
                            <i class="fa-solid fa-calendar-xmark text-6xl text-gray-300 mb-4"></i>
                            <p class="text-xl text-gray-500">Tidak ada jadwal untuk hari ini.</p>
                        </div>
                    `;
                }
                
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('modal-enter');
                }, 10);
            }
            
            function closeModal() {
                modal.classList.add('modal-leave-to');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('modal-leave-to');
                    modal.classList.add('modal-enter');
                }, 300);
            }
            
            showMoreBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const day = this.dataset.day;
                    const title = this.dataset.title;
                    openModal(day, title);
                });
            });
            
            closeModalBtn.addEventListener('click', closeModal);
            
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
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
            
            // Newsletter form functionality
            const newsletterForm = document.querySelector('.flex.flex-col.sm\\:flex-row.gap-2');
            const emailInput = document.querySelector('input[type="email"]');
            const subscribeBtn = document.querySelector('.subscribe-btn');
            
            if (newsletterForm && emailInput && subscribeBtn) {
                subscribeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (!emailInput.value || !isValidEmail(emailInput.value)) {
                        emailInput.focus();
                        emailInput.style.borderColor = '#ef4444';
                        emailInput.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.3)';
                        
                        // Reset border after 3 seconds
                        setTimeout(() => {
                            emailInput.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                            emailInput.style.boxShadow = 'none';
                        }, 3000);
                        return;
                    }
                    
                    emailInput.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                    emailInput.style.boxShadow = 'none';
                    
                    // Show success message
                    const originalText = subscribeBtn.textContent;
                    subscribeBtn.textContent = 'Berhasil!';
                    subscribeBtn.style.background = 'linear-gradient(90deg, #10b981, #059669)';
                    
                    setTimeout(() => {
                        subscribeBtn.textContent = originalText;
                        subscribeBtn.style.background = 'linear-gradient(90deg, #0ea5e9, #0284c7)';
                        emailInput.value = '';
                    }, 2000);
                });
            }
            
            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
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
        });
    </script>
</body>
</html>