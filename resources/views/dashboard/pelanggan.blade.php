<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - POSIFY</title>
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
                    <a href="#" class="text-primary font-semibold">Dashboard</a>
                    <a href="#" class="text-gray-700 hover:text-primary transition">Riwayat Belanja</a>
                    <a href="#" class="text-gray-700 hover:text-primary transition">Profil</a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 bg-gray-100 rounded-full px-4 py-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-primary transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-3xl p-8 text-white mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="text-green-100">Nikmati pengalaman berbelanja yang mudah dan nyaman</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Belanja -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-medium">Total Belanja</h3>
                <p class="text-2xl font-bold text-gray-900 mt-1">Rp 0</p>
                <p class="text-green-600 text-sm mt-2">Sepanjang waktu</p>
            </div>

            <!-- Total Transaksi -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-100 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-medium">Total Transaksi</h3>
                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                <p class="text-gray-500 text-sm mt-2">Pesanan selesai</p>
            </div>

            <!-- Poin Reward -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-yellow-100 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-medium">Poin Reward</h3>
                <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                <p class="text-gray-500 text-sm mt-2">Poin tersedia</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                    <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="font-semibold text-sm">Cari Produk</p>
                </button>
                <button class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                    <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="font-semibold text-sm">Riwayat</p>
                </button>
                <button class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                    <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="font-semibold text-sm">Profil</p>
                </button>
                <button class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                    <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="font-semibold text-sm">Bantuan</p>
                </button>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Riwayat Transaksi Terakhir</h3>
                <button class="text-primary hover:text-red-600 font-semibold text-sm">Lihat Semua</button>
            </div>
            <div class="text-center py-16 text-gray-500">
                <svg class="w-20 h-20 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="font-medium text-lg">Belum Ada Transaksi</p>
                <p class="text-sm mt-2">Anda belum memiliki riwayat transaksi</p>
                <button class="mt-6 bg-gradient-to-r from-primary to-red-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg transition">
                    Mulai Belanja
                </button>
            </div>
        </div>

        <!-- Info Section -->
        <div class="grid md:grid-cols-2 gap-6 mt-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="bg-blue-500 p-3 rounded-xl text-white mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">Informasi Akun</h4>
                        <p class="text-sm text-gray-700"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p class="text-sm text-gray-700"><strong>Telepon:</strong> {{ Auth::user()->phone ?? '-' }}</p>
                        <p class="text-sm text-gray-700"><strong>Alamat:</strong> {{ Auth::user()->address ?? 'Belum diisi' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
                <div class="flex items-start">
                    <div class="bg-green-500 p-3 rounded-xl text-white mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">Program Reward</h4>
                        <p class="text-sm text-gray-700">Kumpulkan poin setiap pembelian dan dapatkan diskon menarik!</p>
                        <button class="mt-3 text-green-600 font-semibold text-sm hover:text-green-700">
                            Pelajari Lebih Lanjut →
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white mt-12 py-8 border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-600">
            <p>&copy; 2025 POSIFY. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
