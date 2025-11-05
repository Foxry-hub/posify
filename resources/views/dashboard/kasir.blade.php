<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Dashboard Kasir</h2>
                        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="flex items-center space-x-2 bg-gray-100 rounded-full px-4 py-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary to-red-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6 md:p-8 max-w-7xl mx-auto">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                    <!-- Penjualan Hari Ini -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium opacity-90">Penjualan Hari Ini</h3>
                        <p class="text-3xl font-bold mt-2">Rp 0</p>
                        <p class="text-sm mt-2 opacity-80">0 transaksi</p>
                    </div>

                    <!-- Transaksi Saya -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium opacity-90">Transaksi Saya</h3>
                        <p class="text-3xl font-bold mt-2">0</p>
                        <p class="text-sm mt-2 opacity-80">Hari ini</p>
                    </div>

                    <!-- Pelanggan Baru -->
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium opacity-90">Pelanggan Baru</h3>
                        <p class="text-3xl font-bold mt-2">0</p>
                        <p class="text-sm mt-2 opacity-80">Bulan ini</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid md:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
                    <a href="{{ route('kasir.transactions.create') }}" class="bg-gradient-to-br from-primary to-red-600 text-white rounded-2xl p-6 md:p-8 hover:shadow-2xl transition-all transform hover:-translate-y-1 block text-center">
                        <svg class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="text-xl md:text-2xl font-bold">Transaksi Baru</h3>
                        <p class="mt-2 opacity-90">Mulai transaksi penjualan</p>
                    </a>

                    <a href="{{ route('kasir.customers.create') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 md:p-8 hover:shadow-2xl transition-all transform hover:-translate-y-1 block text-center">
                        <svg class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <h3 class="text-xl md:text-2xl font-bold">Daftar Pelanggan Baru</h3>
                        <p class="mt-2 opacity-90">Tambah pelanggan baru</p>
                    </a>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Transaksi Terbaru</h3>
                        <a href="{{ route('kasir.transactions.index') }}" class="text-primary hover:text-red-600 font-semibold text-sm">Lihat Semua</a>
                    </div>
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="font-medium">Belum ada transaksi hari ini</p>
                        <p class="text-sm mt-1">Mulai transaksi pertama Anda</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
