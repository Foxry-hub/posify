<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSIFY - Belanja Online Mudah & Terpercaya</title>
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
                    <a href="#categories" class="text-gray-700 hover:text-primary transition">Kategori</a>
                    <a href="#products" class="text-gray-700 hover:text-primary transition">Produk</a>
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
                    <p class="text-primary font-semibold mb-2">Belanja Online Terpercaya</p>
                    <h1 class="text-5xl font-bold text-gray-900 mb-4 leading-tight">
                        Belanja Lebih Mudah
                        <span class="text-primary block mt-2">Harga Terjangkau</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        Temukan berbagai produk berkualitas dengan harga terbaik. Belanja online dengan mudah, 
                        aman, dan cepat. Nikmati pengalaman berbelanja yang menyenangkan bersama kami.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#categories" class="bg-gradient-to-r from-primary to-red-600 text-white px-6 py-3 rounded-full font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-300 inline-block">Belanja Sekarang</a>
                        <a href="#products" class="bg-white text-gray-800 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 inline-block border-2 border-gray-300">Lihat Produk</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-3xl shadow-2xl p-8 transform hover:scale-105 transition-transform duration-300">
                        <div class="aspect-square bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-48 h-48 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -top-6 -right-6 bg-yellow-400 text-gray-900 font-bold px-6 py-3 rounded-full shadow-lg">
                        PROMO SPESIAL
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-12 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Kategori Produk</h2>
            <p class="text-gray-600">Pilih kategori favorit Anda dan mulai berbelanja</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Card 1 - Fashion -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-6 text-white relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="relative z-10">
                    <p class="text-xs opacity-80 mb-1">Trending</p>
                    <h3 class="text-2xl font-bold mb-3">Fashion<br>& Style</h3>
                    <a href="#" class="inline-block bg-primary px-5 py-2 rounded-full text-xs font-semibold hover:bg-red-600 transition">Lihat Produk</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 2 - Elektronik -->
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-2xl p-6 text-gray-900 relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="relative z-10">
                    <p class="text-xs opacity-80 mb-1">Populer</p>
                    <h3 class="text-2xl font-bold mb-3">Elektronik<br>& Gadget</h3>
                    <a href="#" class="inline-block bg-white px-5 py-2 rounded-full text-xs font-semibold hover:bg-gray-100 transition">Lihat Produk</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 3 - Makanan -->
            <div class="bg-gradient-to-br from-primary to-red-600 rounded-2xl p-6 text-white relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="relative z-10">
                    <p class="text-xs opacity-80 mb-1">Fresh</p>
                    <h3 class="text-2xl font-bold mb-3">Makanan<br>& Minuman</h3>
                    <a href="#" class="inline-block bg-white text-primary px-5 py-2 rounded-full text-xs font-semibold hover:bg-gray-100 transition">Lihat Produk</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.06 22.99h1.66c.84 0 1.53-.64 1.63-1.46L23 5.05h-5V1h-1.97v4.05h-4.97l.3 2.34c1.71.47 3.31 1.32 4.27 2.26 1.44 1.42 2.43 2.89 2.43 5.29v8.05zM1 21.99V21h15.03v.99c0 .55-.45 1-1.01 1H2.01c-.56 0-1.01-.45-1.01-1zm15.03-7c0-8-15.03-8-15.03 0h15.03zM1.02 17h15v2h-15z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 4 - Rumah Tangga -->
            <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl p-6 text-gray-900 relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="relative z-10">
                    <p class="text-xs opacity-60 mb-1">Best Seller</p>
                    <h3 class="text-2xl font-bold mb-3">Rumah<br>Tangga</h3>
                    <a href="#" class="inline-block bg-primary text-white px-5 py-2 rounded-full text-xs font-semibold hover:bg-red-600 transition">Lihat Produk</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-5">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 5 - Kesehatan -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="relative z-10">
                    <p class="text-xs opacity-80 mb-1">Terpercaya</p>
                    <h3 class="text-2xl font-bold mb-3">Kesehatan<br>& Kecantikan</h3>
                    <a href="#" class="inline-block bg-white text-green-600 px-5 py-2 rounded-full text-xs font-semibold hover:bg-gray-100 transition">Lihat Produk</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 11h-4v4h-4v-4H6v-4h4V6h4v4h4v4z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 6 - Olahraga -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="relative z-10">
                    <p class="text-xs opacity-80 mb-1">Aktif</p>
                    <h3 class="text-2xl font-bold mb-3">Olahraga<br>& Hobi</h3>
                    <a href="#" class="inline-block bg-white text-blue-600 px-5 py-2 rounded-full text-xs font-semibold hover:bg-gray-100 transition">Lihat Produk</a>
                </div>
                <div class="absolute bottom-0 right-0 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29z"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="products" class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Kenapa Belanja di POSIFY?</h2>
                <p class="text-gray-600">Pengalaman belanja online terbaik untuk Anda</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-5 rounded-xl hover:bg-gray-50 transition">
                    <div class="bg-red-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-2">Produk Berkualitas</h3>
                    <p class="text-gray-600 text-sm">Hanya menjual produk original & terpercaya</p>
                </div>

                <div class="text-center p-5 rounded-xl hover:bg-gray-50 transition">
                    <div class="bg-yellow-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-600 text-sm">Dapatkan harga terbaik setiap hari</p>
                </div>

                <div class="text-center p-5 rounded-xl hover:bg-gray-50 transition">
                    <div class="bg-green-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-2">Gratis Ongkir</h3>
                    <p class="text-gray-600 text-sm">Untuk pembelian tertentu</p>
                </div>

                <div class="text-center p-5 rounded-xl hover:bg-gray-50 transition">
                    <div class="bg-blue-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-2">Layanan 24/7</h3>
                    <p class="text-gray-600 text-sm">Customer service siap membantu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-primary to-red-600 rounded-2xl p-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10 grid md:grid-cols-2 gap-6 items-center">
                <div class="text-white">
                    <div class="inline-block bg-white bg-opacity-20 px-3 py-1 rounded-full text-xs font-semibold mb-3">
                        PROMO TERBATAS
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-3">
                        Dapatkan Diskon
                        <span class="block text-5xl mt-2">50% OFF</span>
                    </h2>
                    <p class="text-base mb-5 opacity-90">Berlaku hingga 31 Desember 2025</p>
                    <a href="#" class="inline-block bg-white text-primary px-6 py-3 rounded-full font-bold text-sm hover:bg-gray-100 transition">
                        Ambil Promo Sekarang
                    </a>
                </div>
                <div class="hidden md:flex justify-center">
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6">
                        <div class="bg-white rounded-xl p-5 shadow-2xl">
                            <div class="aspect-square bg-gradient-to-br from-red-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div>
                    <h3 class="text-xl font-bold mb-3 text-primary">POSIFY</h3>
                    <p class="text-gray-400 text-sm">Belanja online mudah & terpercaya</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 text-sm">Belanja</h4>
                    <ul class="space-y-1.5 text-gray-400 text-sm">
                        <li><a href="#categories" class="hover:text-white transition">Kategori</a></li>
                        <li><a href="#products" class="hover:text-white transition">Produk</a></li>
                        <li><a href="#bestseller" class="hover:text-white transition">Best Seller</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 text-sm">Perusahaan</h4>
                    <ul class="space-y-1.5 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 text-sm">Kontak</h4>
                    <ul class="space-y-1.5 text-gray-400 text-sm">
                        <li>Email: shop@posify.id</li>
                        <li>Telp: +62 812-3456-7890</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; 2025 POSIFY Online Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
