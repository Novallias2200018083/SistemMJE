<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Event - Muhammadiyah Jogja Expo 2025</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                <div class="bg-sky-500 p-3 rounded-xl shadow-lg">
                    <i class="fa-solid fa-calendar-days text-white text-lg"></i>
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
                    class="bg-gray-900 text-white px-5 py-3 rounded-xl font-semibold shadow-lg hover:bg-gray-800 transition-all duration-300"><i
                        class="fa-solid fa-calendar-check mr-2"></i>Pendaftaran</a>
                <a href="{{ route('ticket.find') }}"
                    class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i
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
                    class="text-gray-700 bg-sky-50 text-sky-600 font-semibold px-4 py-3 rounded-lg"><i
                        class="fa-solid fa-calendar-check fa-fw mr-3"></i>Pendaftaran</a>
                <a href="{{ route('ticket.find') }}"
                    class="text-gray-700 hover:bg-sky-50 hover:text-sky-600 font-semibold px-4 py-3 rounded-lg transition-all duration-300"><i
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
            <div class="max-w-3xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl">
                <div class="flex items-start space-x-4 mb-8">
                    <div class="bg-sky-100 text-sky-600 p-4 rounded-xl">
                        <i class="fa-solid fa-user-plus fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Daftar Event</h2>
                        <p class="text-gray-600 mt-2">Daftarkan diri Anda untuk mengikuti Muhammadiyah Jogja Expo 2025.
                            Pendaftaran gratis dan mendapatkan akses ke semua acara.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg" role="alert">
                        <p class="font-bold">Terjadi Kesalahan</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('event.register.submit') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap
                                <span class="text-red-500">*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap Anda" required autofocus
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                        <div>
                            <label for="full_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                Lengkap <span class="text-red-500">*</span></label>
                            <textarea id="full_address" name="full_address" rows="3" placeholder="Jl. Malioboro No. 123, Yogyakarta"
                                required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">{{ old('full_address') }}</textarea>
                        </div>
                        <div>
                            <label for="regency_select"
                                class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota <span
                                    class="text-red-500">*</span></label>
                            <select id="regency_select" name="regency" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                                <option value="" disabled selected>Pilih kabupaten/kota</option>
                                <option value="Kota Yogyakarta"
                                    {{ old('regency') == 'Kota Yogyakarta' ? 'selected' : '' }}>Kota Yogyakarta
                                </option>
                                <option value="Kabupaten Sleman"
                                    {{ old('regency') == 'Kabupaten Sleman' ? 'selected' : '' }}>Kabupaten Sleman
                                </option>
                                <option value="Kabupaten Bantul"
                                    {{ old('regency') == 'Kabupaten Bantul' ? 'selected' : '' }}>Kabupaten Bantul
                                </option>
                                <option value="Kabupaten Kulon Progo"
                                    {{ old('regency') == 'Kabupaten Kulon Progo' ? 'selected' : '' }}>Kabupaten Kulon
                                    Progo</option>
                                <option value="Kabupaten Gunungkidul"
                                    {{ old('regency') == 'Kabupaten Gunungkidul' ? 'selected' : '' }}>Kabupaten
                                    Gunungkidul</option>
                                <option value="Lain-lain" {{ old('regency') == 'Lain-lain' ? 'selected' : '' }}>
                                    Lain-lain</option>
                            </select>
                        </div>
                        <div id="other_regency_wrapper" class="hidden">
                            <label for="other_regency" class="block text-sm font-medium text-gray-700 mb-1">Masukkan
                                Nama Kabupaten/Kota Anda</label>
                            <input id="other_regency" name="other_regency" type="text"
                                value="{{ old('other_regency') }}"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                                    HP <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i
                                            class="fa-solid fa-phone @error('phone_number') text-red-500 @else text-gray-400 @enderror"></i>
                                    </div>
                                    <input id="phone_number" name="phone_number" type="tel"
                                        value="{{ old('phone_number') }}" placeholder="08123456789" required
                                        class="block w-full pl-10 px-4 py-3 border rounded-lg shadow-sm 
                                               @error('phone_number') 
                                                   border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 
                                               @else 
                                                   border-gray-300 focus:ring-sky-500 focus:border-sky-500 
                                               @enderror" />
                                </div>
                                @error('phone_number')
                                    <div class="flex items-center text-red-600 text-sm mt-2">
                                        <i class="fa-solid fa-circle-exclamation mr-2"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Usia <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-calendar text-gray-400"></i>
                                    </div><input id="age" name="age" type="number"
                                        value="{{ old('age') }}" placeholder="25" required
                                        class="block w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                                </div>
                            </div>
                        </div>
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-4 rounded-r-lg">
                            <div class="flex">
                                <div class="py-1"><i class="fa-solid fa-circle-info"></i></div>
                                <div class="ml-3">
                                    <p class="text-sm">Setelah mendaftar, Anda akan mendapatkan <strong>token
                                            unik</strong> yang dapat digunakan untuk presensi di semua hari event dan
                                        mengikuti undian doorprize.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 border-t pt-6">
                        <button type="submit"
                            class="w-full bg-gray-900 text-white font-bold py-4 px-6 rounded-xl hover:bg-gray-700 transition-all duration-300 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-arrow-right-to-bracket mr-3"></i>Daftar Sekarang
                        </button>
                    </div>
                </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

</html>
