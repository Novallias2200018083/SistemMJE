<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muhammadiyah Jogja Expo 2025</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        /* Header Fixed */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgb(18, 36, 74);
            background: linear-gradient(90deg, rgba(18, 36, 74,
            opacity: 80%
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .fixed-header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .fixed-header .container {
            transition: padding 0.3s ease-in-out;
        }
        .fixed-header.scrolled .py-4 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .header-hidden {
            transform: translateY(-100%);
        }

        /* Full Screen Carousel */
        .fullscreen-carousel {
            height: 100vh;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .carousel-slide.active {
            opacity: 1;
        }
        
        .carousel-slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0) 50%);
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-content {
            position: absolute;
            bottom: 20%;
            left: 10%;
            color: white;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
            max-width: 600px;
            z-index: 5;
        }

        .carousel-nav {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 10;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background: white;
            transform: scale(1.2);
        }

        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.3);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .carousel-control:hover {
            background: rgba(0, 0, 0, 0.6);
        }

        .carousel-control.prev {
            left: 20px;
        }

        .carousel-control.next {
            right: 20px;
        }

        /* Section Styles */
        section {
            padding: 80px 0;
        }
        .sponsors-section {
            background: white;
        }

        .sponsors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            align-items: center;
            justify-items: center;
        }

        .sponsor-item {
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 120px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .sponsor-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .sponsor-item img {
            max-width: 100%;
            max-height: 80px;
            object-fit: contain;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .sponsor-item:hover img {
             filter: grayscale(0%);
             opacity: 1;
        }
        
        .schedule-section {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        .join-section {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
        }

        /* Schedule Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-container {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.95);
            transition: all 0.3s ease;
        }
        .modal-overlay.show .modal-container {
             transform: scale(1);
        }
        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-close-btn {
            background: #f1f5f9;
            color: #64748b;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .modal-close-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
            transform: rotate(90deg);
        }
        .modal-body {
            padding: 2rem;
        }

        /* Scroll Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .carousel-content {
                left: 5%;
                bottom: 15%;
                max-width: 90%;
            }
            .carousel-content h1 {
                font-size: 2rem;
            }
            .carousel-control {
                width: 40px;
                height: 40px;
            }
            section {
                padding: 60px 0;
            }
        }

        @media (max-width: 480px) {
            .carousel-content h1 {
                font-size: 1.8rem;
            }
            .carousel-content p {
                font-size: 0.9rem;
            }
            .sponsors-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
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
            transform: translateY(20px);
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
            50% { transform: translatey(-15px); }
            100% { transform: translatey(0px); }
        }
    </style>
</head>

<body class="antialiased">
    <header class="fixed-header " id="main-header">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-sky-500 p-3 rounded-xl shadow-lg floating-animation">
                        <i class="fa-solid fa-calendar-days text-white text-lg"></i>
                    </div>
                    <a href="{{ route('home') }}" class="font-bold text-xl">
                        <span class="logo-text text-white">Muhammadiyah</span><br>
                        <span class="text-amber-500">Jogja Expo 2025</span>
                    </a>
                </div>

                <nav class="hidden md:flex items-center space-x-2 text-black-600 text-bold">
                    <a href="#hero" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300">Beranda</a>
                    <a href="{{ route('event.register.form') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300">Pendaftaran</a>
                    <a href="{{ route('ticket.find') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300">Cetak Tiket</a>
                    <a href="{{ route('lottery.check') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300">Cek Undian</a>
                    <a href="{{ route('news.index') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300">Portal Berita</a>
                </nav>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="px-6 py-3 border-2 border-sky-500 text-sky-600 rounded-xl font-semibold hover:bg-sky-500 hover:text-white transition-all duration-300">Portal Tenan</a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white-800 hover:text-sky-600 focus:outline-none" aria-label="Open menu">
                        <i class="fa-solid fa-bars color-white text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white rounded-2xl shadow-lg mt-2 absolute top-full left-4 right-4 z-20">
            <nav class="flex flex-col p-7 space-y-5">
                <a href="#hero" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-house fa-fw mr-3"></i>Beranda</a>
                <a href="{{ route('event.register.form') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-calendar-check fa-fw mr-3"></i>Pendaftaran</a>
                <a href="{{ route('ticket.find') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-print fa-fw mr-3"></i>Cetak Tiket</a>
                <a href="{{ route('lottery.check') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-ticket fa-fw mr-3"></i>Cek Undian</a>
                <a href="{{ route('news.index') }}" class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i class="fa-solid fa-newspaper fa-fw mr-3"></i>Portal Berita</a>
                <a href="{{ route('login') }}" class="w-full text-center px-6 py-3 border-2 border-sky-500 text-sky-600 rounded-xl font-semibold hover:bg-sky-500 hover:text-white transition-all duration-300">Portal Tenan</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="fullscreen-carousel mt-[5.5rem]" id="hero">
            <div class="carousel-slide active">
                <img src="{{ asset('images/logomje.jpg') }}" alt="Muhammadiyah Jogja Expo">
                <div class="carousel-content">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-10">Muhammadiyah Jogja Expo 2025</h1>
                    <p class="text-xl md:text-2xl mb-6">Event Tahunan Terbesar Muhammadiyah Yogyakarta</p>
                    <a href="{{ route('event.register.form') }}" class="bg-white text-sky-600 font-bold py-3 px-8 rounded-xl hover:bg-amber-50 hover:text-amber-600 transition-all duration-300 shadow-lg inline-flex items-center">
                        <i class="fa-solid fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </a>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('images/mje1.jpg') }}" alt="Inovasi dan Kreativitas">
                <div class="carousel-content mb-10">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-10">Inovasi dan Kreativitas</h1>
                    <p class="text-xl md:text-2xl mb-6">Temukan berbagai inovasi terbaru dari Muhammadiyah Yogyakarta</p>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('images/mje2.jpeg') }}" alt="Kolaborasi dan Sinergi">
                <div class="carousel-content mb-10">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-10">Kolaborasi dan Sinergi</h1>
                    <p class="text-xl md:text-2xl mb-6">Bersama membangun masa depan yang lebih baik</p>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('images/mje3.jpg') }}" alt="Acara Inspiratif">
                <div class="carousel-content mb-10">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-10">3 Hari Penuh Inspirasi</h1>
                    <p class="text-xl md:text-2xl mb-6">Jangan lewatkan berbagai acara menarik selama 3 hari</p>
                </div>
            </div>

            <div class="carousel-control prev" aria-label="Previous slide"><i class="fa-solid fa-chevron-left"></i></div>
            <div class="carousel-control next" aria-label="Next slide"><i class="fa-solid fa-chevron-right"></i></div>
            <div class="carousel-nav mb-20"></div>
        </section>

        <section class="schedule-section" id="schedule">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl animate-on-scroll">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 md:mb-0">Jadwal Acara</h2>
                        <span class="bg-gradient-to-r from-sky-100 to-blue-100 text-sky-700 font-semibold px-6 py-3 rounded-xl border border-sky-200">3 Hari Event</span>
                    </div>
                    <div class="space-y-10">
                        @for ($i = 1; $i <= 3; $i++)
                            @php $eventsThisDay = $eventsByDay->get($i, collect()); @endphp
                            <div class="border-l-4 border-sky-500 p-6 rounded-2xl bg-slate-50">
                                <h3 class="text-2xl font-bold text-sky-600 mb-6 flex items-center">
                                    <i class="fa-solid fa-calendar-day mr-3 text-3xl"></i>
                                    Hari {{ $i }} - Event Day {{ $i }}
                                </h3>
                                @forelse($eventsThisDay->take(3) as $event)
                                    <div class="bg-white p-6 rounded-xl mb-4 border border-gray-200 transition-all duration-300 hover:shadow-md hover:border-sky-200">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="font-bold text-lg text-gray-800 mb-2">{{ $event->title }}</p>
                                                <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                                                <div class="flex items-center space-x-6 text-sm text-gray-500">
                                                    <span class="flex items-center bg-gray-100 px-3 py-2 rounded-lg"><i class="fa-regular fa-clock mr-2 text-sky-500"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                                                    <span class="flex items-center bg-gray-100 px-3 py-2 rounded-lg"><i class="fa-solid fa-location-dot mr-2 text-red-500"></i> {{ $event->location }}</span>
                                                </div>
                                            </div>
                                            <span class="text-sm font-semibold bg-sky-500 text-white px-4 py-2 rounded-full ml-4 hidden sm:block">Hari {{ $i }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500">Jadwal untuk hari ke-{{ $i }} akan segera diumumkan.</p>
                                    </div>
                                @endforelse

                                @if ($eventsThisDay->count() > 3)
                                    <div class="text-center mt-6">
                                        <button class="show-more-btn px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg" data-day="{{ $i }}" data-title="Rundown Lengkap Hari {{ $i }}">
                                            Lihat Lebih Banyak <i class="fa-solid fa-chevron-down ml-2"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </section>


        <section class="my-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Tenan Terlaris</h2>
                    <p class="text-lg sm:text-xl text-gray-600">Tenan dengan performa terbaik di expo ini</p>
                </div>

                <!-- Grid responsif -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($topTenants as $category => $tenants)
                        <div class="tenant-card p-6 sm:p-8 rounded-2xl shadow-lg card-hover">
                            <div class="text-center mb-6">
                                <h3
                                    class="text-xl sm:text-2xl font-bold mb-2 capitalize flex items-center justify-center">
                                    <i class="fa-solid fa-star text-amber-400 mr-2 sm:mr-3 text-lg sm:text-2xl"></i>
                                    {{ str_replace('_', ' ', $category) }}
                                </h3>
                                <p class="text-gray-500 text-sm sm:text-base">Tenan dengan penjualan tertinggi</p>
                            </div>

                            <ul class="space-y-3 sm:space-y-4">
                                @forelse($tenants as $index => $tenant)
                                    <li
                                        class="flex justify-between items-center p-3 sm:p-4 rounded-xl 
                            {{ $index == 0
                                ? 'bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-400'
                                : ($index == 1
                                    ? 'bg-gradient-to-r from-gray-50 to-slate-50 border-l-4 border-gray-400'
                                    : 'bg-gradient-to-r from-orange-50 to-red-50 border-l-4 border-orange-400') }}">
                                        <div class="flex items-center">
                                            <span
                                                class="{{ $index == 0 ? 'bg-amber-400 text-white' : ($index == 1 ? 'bg-gray-400 text-white' : 'bg-orange-400 text-white') }} rounded-full w-7 h-7 sm:w-8 sm:h-8 inline-flex items-center justify-center mr-3 sm:mr-4 font-bold text-xs sm:text-sm">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="font-semibold text-gray-800 text-sm sm:text-base">
                                                {{ $tenant->tenant_name }}
                                            </span>
                                        </div>
                                        <span class="font-bold text-gray-700 text-sm sm:text-base">
                                            {{ number_format($tenant->total_sales, 0, ',', '.') }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="text-center py-6">
                                        <i class="fa-solid fa-chart-line text-2xl sm:text-3xl text-gray-300 mb-2"></i>
                                        <p class="text-gray-400 text-sm sm:text-base">Belum ada data penjualan.</p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    @endforeach
                </div>
            </section>

        <section 
            id="join" 
            class="relative min-h-screen flex items-center justify-center text-white" 
            style="background-image: url('{{ asset('images/muhammadiyah-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
        >
            <div class="absolute top-0 left-0 w-full h-full bg-black/60 z-0"></div>

            <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center z-10 animate-on-scroll">
                <div class="max-w-3xl">
                    <h2 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">
                        Jadilah Bagian Dari <br class="md:hidden">
                        <span class="text-amber-400">Gerakan Pencerahan</span>
                    </h2>
                    <p class="text-lg md:text-xl text-white/90 mx-auto mb-10" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.7);">
                        Jangan lewatkan kesempatan untuk berpartisipasi dalam event terbesar Muhammadiyah Jogja. Daftar sekarang sebagai peserta atau jadi bagian dari pameran sebagai tenan.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                        <a href="{{ route('event.register.form') }}" class="w-full sm:w-auto bg-amber-400 text-slate-900 font-bold py-4 px-8 rounded-xl hover:bg-amber-500 transition-all duration-300 shadow-lg flex items-center justify-center transform hover:-translate-y-1">
                            <i class="fa-solid fa-user-plus mr-3"></i>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto bg-transparent border-2 border-white/80 text-white font-bold py-4 px-8 rounded-xl hover:bg-white/10 hover:border-white transition-all duration-300 flex items-center justify-center">
                            <i class="fa-solid fa-store mr-3"></i>
                            Jadi Tenan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        
    </main>

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

    <button id="back-to-top" class="back-to-top" aria-label="Back to top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>
    
    <div id="schedule-modal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="modal-title" class="text-2xl font-bold text-gray-800"></h2>
                <button id="modal-close" class="modal-close-btn" aria-label="Close modal">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div id="modal-body" class="modal-body space-y-4">
                </div>
        </div>
    </div>
    
    <script>
    // Dummy Data for the Modal - in a real Laravel app, you'd pass this from the controller
    const allEvents = @json($eventsByDay);

    document.addEventListener('DOMContentLoaded', () => {
        // --- Header Scroll Logic ---
        const header = document.getElementById('main-header');
        let lastScrollY = window.scrollY;
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            if (lastScrollY < window.scrollY && window.scrollY > 150) {
                header.classList.add('header-hidden');
            } else {
                header.classList.remove('header-hidden');
            }
            lastScrollY = window.scrollY;
        });

        // --- Mobile Menu Toggle ---
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when a link is clicked
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // --- Fullscreen Carousel Logic ---
        const slides = document.querySelectorAll('.carousel-slide');
        const navContainer = document.querySelector('.carousel-nav');
        const prevBtn = document.querySelector('.carousel-control.prev');
        const nextBtn = document.querySelector('.carousel-control.next');
        const carousel = document.querySelector('.fullscreen-carousel');
        let currentSlide = 0;
        let slideInterval;

        // Create dots
        slides.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.classList.add('carousel-dot');
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => {
                goToSlide(i);
                resetInterval();
            });
            navContainer.appendChild(dot);
        });
        const dots = document.querySelectorAll('.carousel-dot');

        const goToSlide = (slideIndex) => {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            currentSlide = (slideIndex + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        };

        nextBtn.addEventListener('click', () => {
            goToSlide(currentSlide + 1);
            resetInterval();
        });
        prevBtn.addEventListener('click', () => {
            goToSlide(currentSlide - 1);
            resetInterval();
        });

        const startInterval = () => {
            slideInterval = setInterval(() => {
                goToSlide(currentSlide + 1);
            }, 5000); // Change slide every 5 seconds
        };
        const resetInterval = () => {
            clearInterval(slideInterval);
            startInterval();
        };
        
        carousel.addEventListener('mouseenter', () => clearInterval(slideInterval));
        carousel.addEventListener('mouseleave', startInterval);

        startInterval();
        
        // --- Schedule Modal Logic ---
        const modal = document.getElementById('schedule-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalBody = document.getElementById('modal-body');
        const modalCloseBtn = document.getElementById('modal-close');
        
        document.querySelectorAll('.show-more-btn').forEach(button => {
            button.addEventListener('click', () => {
                const day = button.dataset.day;
                const title = button.dataset.title;
                const events = allEvents[day] || [];
                
                modalTitle.textContent = title;
                modalBody.innerHTML = ''; // Clear previous content

                if (events.length > 0) {
                     events.forEach(event => {
                        const eventHtml = `
                                <div class="bg-slate-50 p-4 rounded-lg border-l-4 border-sky-400">
                                    <p class="font-bold text-gray-800">${event.title}</p>
                                    <p class="text-gray-600 text-sm my-2">${event.description}</p>
                                    <div class="flex items-center space-x-4 text-xs text-gray-500 mt-3">
                                        <span class="flex items-center"><i class="fa-regular fa-clock mr-2 text-sky-500"></i> ${event.formatted_time}</span>
                                        <span class="flex items-center"><i class="fa-solid fa-location-dot mr-2 text-red-500"></i> ${event.location}</span>
                                    </div>
                                </div>
                            `;
                        modalBody.insertAdjacentHTML('beforeend', eventHtml);
                    });
                } else {
                     modalBody.innerHTML = '<p class="text-gray-500">Jadwal belum tersedia.</p>';
                }

                modal.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            });
        });
        
        const closeModal = () => {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        };

        modalCloseBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape" && modal.classList.contains('show')) {
                 closeModal();
            }
        });


        // --- Back to Top Button ---
        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
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
        
        // --- Smooth Scrolling for Anchor Links ---
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // --- Animate on Scroll (Intersection Observer) ---
        const animatedElements = document.querySelectorAll('.animate-on-scroll');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        animatedElements.forEach(el => {
            observer.observe(el);
        });
    });
    </script>
</body>
</html>