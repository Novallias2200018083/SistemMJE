<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Muhammadiyah Jogja Expo 2025</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        .logo-text {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
    </style>
</head>
<body class="antialiased">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header & Navigation -->
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
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-6 text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-house mr-2"></i>Beranda</a>
                <a href="{{ route('event.register.form') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-calendar-check mr-2"></i>Pendaftaran</a>
                 <a href="{{ route('ticket.find') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-ticket mr-2"></i>Cetak Tiket</a>
                <a href="{{ route('lottery.check') }}" class="hover:text-sky-600 font-semibold px-3 py-2 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-ticket mr-2"></i>Cek Undian</a>
            </nav>
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-sky-500 text-white rounded-xl font-semibold hover:bg-sky-600 transition-all duration-300 shadow-lg">Portal Tenan</a>
            </div>

            <!-- Mobile Menu Button (Hamburger Icon) -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-600 text-2xl focus:outline-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </header>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden w-full absolute top-20 right-0 p-4 bg-white rounded-lg shadow-xl transition-all duration-500 ease-in-out">
            <nav class="flex flex-col space-y-4 text-gray-700">
                <a href="{{ route('home') }}" class="font-semibold px-4 py-3 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-house mr-3"></i>Beranda</a>
                <a href="{{ route('event.register.form') }}" class="font-semibold px-4 py-3 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-calendar-check mr-3"></i>Pendaftaran</a>
                <a href="{{ route('ticket.find') }}" class="font-semibold px-4 py-3 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-ticket mr-3"></i>Cetak Tiket</a>
                <a href="{{ route('lottery.check') }}" class="font-semibold px-4 py-3 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-ticket mr-3"></i>Cek Undian</a>
                <a href="{{ route('login') }}" class="text-center bg-gray-900 text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-700 transition-all duration-300 mt-4">Portal Tenan</a>
            </nav>
        </div>

        <!-- Main Content: Login Form -->
        <main class="my-12 flex items-center justify-center">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang Kembali</h2>
                    <p class="text-gray-600 mt-2">Login ke akun Tenan Anda.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg" role="alert">
                        <p class="font-bold">Login Gagal</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input id="password" name="password" type="password" required autocomplete="current-password" class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 px-6 rounded-xl hover:bg-gray-700 transition-all duration-300 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-right-to-bracket mr-3"></i>Log In
                        </button>
                    </div>
                    <div class="mt-6 text-center text-sm text-gray-500">
                        Belum punya akun tenan? <a href="{{ route('register') }}" class="font-semibold text-sky-600 hover:underline">Daftar di sini</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function () {
                // Toggle the 'hidden' class to show/hide the menu
                mobileMenu.classList.toggle('hidden');
            });

            // Optional: Close the menu when a link is clicked
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });
        });
    </script>
</body>
</html>
