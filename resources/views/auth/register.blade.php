<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Tenan - Muhammadiyah Jogja Expo 2025</title>

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
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-sky-500 text-white rounded-xl font-semibold hover:bg-sky-600 transition-all duration-300 shadow-lg">Sudah Punya Akun? Login</a>
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
                <a href="{{ route('lottery.check') }}" class="font-semibold px-4 py-3 rounded-lg hover:bg-sky-50 transition-all duration-300"><i class="fa-solid fa-ticket mr-3"></i>Cek Undian</a>
                <!-- Tautan Login tambahan untuk mobile -->
                <a href="{{ route('login') }}" class="text-center bg-gray-900 text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-700 transition-all duration-300 mt-4">Sudah Punya Akun? Login</a>
            </nav>
        </div>

        <!-- Main Content: Registration Form -->
        <main class="my-12 flex items-center justify-center">
            <div class="w-full max-w-2xl bg-white p-8 rounded-2xl shadow-xl">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Daftar Akun Tenan</h2>
                    <p class="text-gray-600 mt-2">Buat akun Anda untuk mulai mengelola data penjualan.</p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg" role="alert">
                        <p class="font-bold">Registrasi Gagal</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik Akun</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                        <div>
                            <label for="tenant_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Tenan / Usaha</label>
                            <input id="tenant_name" name="tenant_name" type="text" value="{{ old('tenant_name') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori Tenan</label>
                                <select id="category" name="category" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                                    <option value="makanan">Makanan</option>
                                    <option value="multi_produk">Multi Produk</option>
                                    <option value="ranting">Ranting</option>
                                </select>
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                                <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                            </div>
                        </div>
                        <hr/>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input id="password" name="password" type="password" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 px-6 rounded-xl hover:bg-gray-700 transition-all duration-300 flex items-center justify-center shadow-lg">
                            Daftar Akun
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            // Tambahkan fungsionalitas untuk menyembunyikan/menampilkan menu
            mobileMenuButton.addEventListener('click', function () {
                const isMenuHidden = mobileMenu.classList.contains('hidden');
                if (isMenuHidden) {
                    mobileMenu.classList.remove('hidden');
                    mobileMenuButton.innerHTML = '<i class="fa-solid fa-times"></i>'; // Ganti ikon menjadi "X"
                } else {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Kembalikan ikon hamburger
                }
            });

            // Opsional: Tutup menu saat link diklik
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.innerHTML = '<i class="fa-solid fa-bars"></i>'; // Kembalikan ikon hamburger
                });
            });
        });
    </script>
</body>
</html>
