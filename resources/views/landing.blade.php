<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSIFY - Sistem Kasir Modern & Terpercaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-primary">POSIFY</h1>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-700 hover:text-primary transition">Beranda</a>
                    <a href="#features" class="text-gray-700 hover:text-primary transition">Fitur</a>
                    <a href="#pricing" class="text-gray-700 hover:text-primary transition">Harga</a>
                    <a href="#contact" class="text-gray-700 hover:text-primary transition">Kontak</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary transition font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-primary to-red-600 text-white px-6 py-2 rounded-full font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-300 inline-block text-sm">Daftar Gratis</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-gray-100 to-gray-200 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-primary font-semibold mb-2">Sistem Kasir Terpercaya</p>
                    <h1 class="text-5xl font-bold text-gray-900 mb-4 leading-tight">
                        Kelola Toko Anda dengan
                        <span class="text-primary block mt-2">Lebih Mudah</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        Sistem Point of Sale modern yang membantu Anda mengelola kasir, inventori, 
                        dan laporan penjualan dengan mudah dan cepat. Tingkatkan efisiensi bisnis Anda hari ini.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="btn-primary">Mulai Gratis</a>
                        <a href="#" class="btn-secondary">Lihat Demo</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-3xl shadow-2xl p-8 transform hover:scale-105 transition-transform duration-300">
                        <div class="aspect-square bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-48 h-48 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -top-6 -right-6 bg-yellow-400 text-gray-900 font-bold px-6 py-3 rounded-full shadow-lg">
                        GRATIS 30 HARI
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1 - Transaksi -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 text-white relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="relative z-10">
                    <p class="text-sm opacity-80 mb-2">Mudah</p>
                    <h3 class="text-3xl font-bold mb-4">Transaksi<br>Cepat</h3>
                    <a href="#" class="inline-block bg-primary px-6 py-2 rounded-full text-sm font-semibold hover:bg-red-600 transition">Lihat Fitur</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 2 - Inventori -->
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-3xl p-8 text-gray-900 relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="relative z-10">
                    <p class="text-sm opacity-80 mb-2">Kelola</p>
                    <h3 class="text-3xl font-bold mb-4">Inventori<br>Smart</h3>
                    <a href="#" class="inline-block bg-white px-6 py-2 rounded-full text-sm font-semibold hover:bg-gray-100 transition">Lihat Fitur</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 7h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v3H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zM10 4h4v3h-4V4zm10 16H4V9h16v11z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 3 - Laporan -->
            <div class="bg-gradient-to-br from-primary to-red-600 rounded-3xl p-8 text-white relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="relative z-10">
                    <p class="text-sm opacity-80 mb-2">Analisis</p>
                    <h3 class="text-3xl font-bold mb-4">Laporan<br>Detail</h3>
                    <a href="#" class="inline-block bg-white text-primary px-6 py-2 rounded-full text-sm font-semibold hover:bg-gray-100 transition">Lihat Fitur</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 4 - Kasir -->
            <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl p-8 text-gray-900 relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="relative z-10">
                    <p class="text-sm opacity-60 mb-2">Terbaik</p>
                    <h3 class="text-3xl font-bold mb-4">Multi<br>Kasir</h3>
                    <a href="#" class="inline-block bg-primary text-white px-6 py-2 rounded-full text-sm font-semibold hover:bg-red-600 transition">Lihat Fitur</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-5">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 5 - Cloud -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-3xl p-8 text-white relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="relative z-10">
                    <p class="text-sm opacity-80 mb-2">Aman</p>
                    <h3 class="text-3xl font-bold mb-4">Cloud<br>Backup</h3>
                    <a href="#" class="inline-block bg-white text-green-600 px-6 py-2 rounded-full text-sm font-semibold hover:bg-gray-100 transition">Lihat Fitur</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 6 - Mobile -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl p-8 text-white relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="relative z-10">
                    <p class="text-sm opacity-80 mb-2">Fleksibel</p>
                    <h3 class="text-3xl font-bold mb-4">Mobile<br>App</h3>
                    <a href="#" class="inline-block bg-white text-blue-600 px-6 py-2 rounded-full text-sm font-semibold hover:bg-gray-100 transition">Lihat Fitur</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-gray-600 text-lg">Solusi lengkap untuk kebutuhan kasir modern Anda</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 rounded-xl hover:bg-gray-50 transition">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Proses Cepat</h3>
                    <p class="text-gray-600 text-sm">Transaksi dalam hitungan detik</p>
                </div>

                <div class="text-center p-6 rounded-xl hover:bg-gray-50 transition">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Keamanan Terjamin</h3>
                    <p class="text-gray-600 text-sm">Data terenkripsi & backup otomatis</p>
                </div>

                <div class="text-center p-6 rounded-xl hover:bg-gray-50 transition">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Laporan Real-time</h3>
                    <p class="text-gray-600 text-sm">Monitor penjualan kapan saja</p>
                </div>

                <div class="text-center p-6 rounded-xl hover:bg-gray-50 transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Support 24/7</h3>
                    <p class="text-gray-600 text-sm">Tim siap membantu Anda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-primary to-red-600 rounded-3xl p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10 grid md:grid-cols-2 gap-8 items-center">
                <div class="text-white">
                    <div class="inline-block bg-white bg-opacity-20 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                        PROMO TERBATAS
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        Dapatkan Diskon
                        <span class="block text-6xl mt-2">50% OFF</span>
                    </h2>
                    <p class="text-lg mb-6 opacity-90">Berlaku hingga 31 Desember 2025</p>
                    <a href="#" class="inline-block bg-white text-primary px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition">
                        Ambil Promo Sekarang
                    </a>
                </div>
                <div class="hidden md:flex justify-center">
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8">
                        <div class="bg-white rounded-2xl p-6 shadow-2xl">
                            <div class="aspect-square bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center">
                                <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Paket Harga Terjangkau</h2>
                <p class="text-gray-600 text-lg">Pilih paket yang sesuai dengan kebutuhan bisnis Anda</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Basic -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition">
                    <h3 class="text-2xl font-bold mb-2">Starter</h3>
                    <p class="text-gray-600 mb-6">Untuk usaha kecil</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold">Rp 99K</span>
                        <span class="text-gray-600">/bulan</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>1 Kasir Aktif</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>100 Produk</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Laporan Dasar</span>
                        </li>
                    </ul>
                    <a href="#" class="block text-center bg-gray-200 text-gray-800 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition">
                        Pilih Paket
                    </a>
                </div>

                <!-- Pro - Popular -->
                <div class="bg-gradient-to-br from-primary to-red-600 rounded-2xl p-8 shadow-2xl transform scale-105 text-white relative">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-gray-900 px-4 py-1 rounded-bl-xl rounded-tr-xl text-sm font-bold">
                        POPULER
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Professional</h3>
                    <p class="text-red-100 mb-6">Untuk usaha menengah</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold">Rp 249K</span>
                        <span class="text-red-100">/bulan</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>5 Kasir Aktif</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Unlimited Produk</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Laporan Lengkap</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Mobile App</span>
                        </li>
                    </ul>
                    <a href="#" class="block text-center bg-white text-primary px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                        Pilih Paket
                    </a>
                </div>

                <!-- Enterprise -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition">
                    <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                    <p class="text-gray-600 mb-6">Untuk usaha besar</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold">Rp 499K</span>
                        <span class="text-gray-600">/bulan</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Unlimited Kasir</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Unlimited Produk</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Analytics Advanced</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Priority Support</span>
                        </li>
                    </ul>
                    <a href="#" class="block text-center bg-gray-200 text-gray-800 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition">
                        Pilih Paket
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-primary">POSIFY</h3>
                    <p class="text-gray-400">Solusi kasir modern untuk bisnis Anda</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Produk</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#" class="hover:text-white transition">Harga</a></li>
                        <li><a href="#" class="hover:text-white transition">Demo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: info@posify.id</li>
                        <li>Telp: +62 812-3456-7890</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 POSIFY. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
