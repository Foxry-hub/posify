<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 md:px-8 py-4">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button onclick="toggleSidebar()" class="lg:hidden mr-4 text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900">Dashboard Admin</h2>
                            <p class="text-sm md:text-base text-gray-600 hidden sm:block">Selamat datang, {{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center space-x-2 bg-gray-100 rounded-full px-3 md:px-4 py-2 hover:bg-gray-200 transition">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary to-red-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="font-medium hidden md:inline">{{ Auth::user()->name }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Total Penjualan -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 md:p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between mb-3 md:mb-4">
                            <div class="bg-white bg-opacity-20 p-2 md:p-3 rounded-xl">
                                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xs md:text-sm font-medium opacity-90">Total Penjualan</h3>
                        <p class="text-2xl md:text-3xl font-bold mt-1 md:mt-2">Rp {{ number_format($totalSalesToday, 0, ',', '.') }}</p>
                        <p class="text-xs md:text-sm mt-1 md:mt-2 opacity-80">Hari ini</p>
                    </div>

                    <!-- Total Transaksi -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-4 md:p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between mb-3 md:mb-4">
                            <div class="bg-white bg-opacity-20 p-2 md:p-3 rounded-xl">
                                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xs md:text-sm font-medium opacity-90">Total Transaksi</h3>
                        <p class="text-2xl md:text-3xl font-bold mt-1 md:mt-2">{{ $totalTransactionsToday }}</p>
                        <p class="text-xs md:text-sm mt-1 md:mt-2 opacity-80">Hari ini</p>
                    </div>

                    <!-- Total Produk -->
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-4 md:p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between mb-3 md:mb-4">
                            <div class="bg-white bg-opacity-20 p-2 md:p-3 rounded-xl">
                                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xs md:text-sm font-medium opacity-90">Total Produk</h3>
                        <p class="text-2xl md:text-3xl font-bold mt-1 md:mt-2">{{ $totalProducts }}</p>
                        <p class="text-xs md:text-sm mt-1 md:mt-2 opacity-80">Item tersedia</p>
                    </div>

                    <!-- Total Pengguna -->
                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-4 md:p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between mb-3 md:mb-4">
                            <div class="bg-white bg-opacity-20 p-2 md:p-3 rounded-xl">
                                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xs md:text-sm font-medium opacity-90">Total Pengguna</h3>
                        <p class="text-2xl md:text-3xl font-bold mt-1 md:mt-2">{{ $totalUsers }}</p>
                        <p class="text-xs md:text-sm mt-1 md:mt-2 opacity-80">Akun terdaftar</p>
                    </div>
                </div>

                <!-- Recent Activity & Chart -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                    <!-- Recent Transactions -->
                    <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4">Transaksi Terbaru</h3>
                        @if($recentTransactions->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentTransactions as $transaction)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-gradient-to-br from-primary to-red-600 p-3 rounded-lg text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $transaction->invoice_number }}</p>
                                                <p class="text-sm text-gray-500">{{ $transaction->user->name ?? 'Kasir' }} • {{ $transaction->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-gray-900">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                                            <p class="text-sm text-gray-500">{{ $transaction->items->count() }} item</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p>Belum ada transaksi</p>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-3 md:gap-4">
                            <button class="bg-gradient-to-br from-primary to-red-600 text-white rounded-xl p-3 md:p-4 hover:shadow-lg transition" onclick="window.location.href='{{ route('admin.products.create') }}'">
                                <svg class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <p class="text-xs md:text-sm font-semibold">Tambah Barang</p>
                            </button>
                            <button class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-3 md:p-4 hover:shadow-lg transition" onclick="window.location.href='{{ route('admin.users.create') }}'">
                                <svg class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                <p class="text-xs md:text-sm font-semibold">Tambah Pengguna</p>
                            </button>
                            <button class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-3 md:p-4 hover:shadow-lg transition" onclick="window.location.href='{{ route('admin.reports.index') }}'">
                                <svg class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-xs md:text-sm font-semibold">Lihat Laporan</p>
                            </button>
                            <button class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-3 md:p-4 hover:shadow-lg transition" onclick="window.location.href='{{ route('admin.transactions.index') }}'">
                                <svg class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <p class="text-xs md:text-sm font-semibold">Riwayat Transaksi</p>
                            </button>
                        </div>
                    </div>
                </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
