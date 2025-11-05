<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi Saya - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-primary">
                        POSIFY
                    </a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-primary transition">
                        Dashboard
                    </a>
                    @if(Auth::user()->member)
                        <a href="{{ route('pelanggan.member.index') }}" class="text-gray-700 hover:text-primary transition">
                            Member
                        </a>
                    @endif
                    <a href="{{ route('pelanggan.transactions.index') }}" class="text-primary font-semibold border-b-2 border-primary pb-1">
                        Riwayat Belanja
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 bg-gray-100 rounded-full px-4 py-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary to-red-600 rounded-full flex items-center justify-center text-white font-bold">
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Riwayat Transaksi Saya</h1>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
            <div class="bg-gradient-to-br from-primary to-red-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Total Belanja</p>
                        <h3 class="text-2xl md:text-3xl font-bold">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Total Transaksi</p>
                        <h3 class="text-2xl md:text-3xl font-bold">{{ $totalTransactions }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                        <i class="fas fa-receipt text-3xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Total Item Dibeli</p>
                        <h3 class="text-2xl md:text-3xl font-bold">{{ $totalItems }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                            <i class="fas fa-shopping-bag fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
        <div class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-4">
            <h5 class="text-lg font-semibold flex items-center gap-2">
                <i class="fas fa-filter"></i> Filter Transaksi
            </h5>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('pelanggan.transactions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                           id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                           id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                    <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                            id="payment_method" name="payment_method">
                        <option value="">Semua</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="debit" {{ request('payment_method') == 'debit' ? 'selected' : '' }}>Debit</option>
                        <option value="credit" {{ request('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>
                        <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('pelanggan.transactions.index') }}" 
                       class="bg-gradient-to-br from-gray-500 to-gray-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-4">
            <h5 class="text-lg font-semibold flex items-center gap-2">
                <i class="fas fa-list"></i> Daftar Transaksi
            </h5>
        </div>
        <div class="p-6">
            @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">No</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Kode Transaksi</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Kasir</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Jumlah Item</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Metode Pembayaran</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Total Belanja</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">{{ $transactions->firstItem() + $loop->index }}</td>
                                    <td class="py-3 px-4">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm">{{ $transaction->transaction_code }}</span>
                                    </td>
                                    <td class="py-3 px-4">{{ $transaction->user->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm">{{ $transaction->items_count }} item</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($transaction->payment_method == 'cash')
                                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Cash</span>
                                        @elseif($transaction->payment_method == 'debit')
                                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm">Debit</span>
                                        @elseif($transaction->payment_method == 'credit')
                                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">Credit</span>
                                        @elseif($transaction->payment_method == 'qris')
                                            <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-sm">QRIS</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-bold text-green-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('pelanggan.transactions.show', $transaction) }}" 
                                           class="bg-gradient-to-br from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:shadow-md transition inline-flex items-center gap-2" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="6" class="py-3 px-4 text-right">Total di Halaman Ini:</td>
                                <td class="py-3 px-4">Rp {{ number_format($transactions->sum('total'), 0, ',', '.') }}</td>
                                <td class="py-3 px-4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-4">
                    <div class="text-gray-600">
                        Menampilkan {{ $transactions->firstItem() }} sampai {{ $transactions->lastItem() }} 
                        dari {{ $transactions->total() }} transaksi
                    </div>
                    <div>
                        {{ $transactions->links() }}
                    </div>
                </div>
            @else
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 px-4 py-3 rounded-lg shadow">
                    <i class="fas fa-info-circle"></i> 
                    @if(request()->hasAny(['start_date', 'end_date', 'payment_method']))
                        Tidak ada transaksi yang sesuai dengan filter yang dipilih.
                    @else
                        Anda belum memiliki transaksi.
                    @endif
                </div>
            @endif
        </div>
    </div>
    </div>
</body>
</html>
