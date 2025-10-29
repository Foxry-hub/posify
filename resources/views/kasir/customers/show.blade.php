<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggan - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('kasir.customers.index') }}" class="text-primary hover:text-blue-700 font-semibold flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Pelanggan
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pelanggan</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Customer Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-8 text-center">
                        <div class="w-24 h-24 bg-white rounded-full mx-auto flex items-center justify-center mb-4">
                            <span class="text-primary font-bold text-3xl">{{ strtoupper(substr($customer->name, 0, 2)) }}</span>
                        </div>
                        <h2 class="text-white text-2xl font-bold">{{ $customer->name }}</h2>
                        @if($customer->is_active)
                            <span class="inline-block mt-2 px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                Aktif
                            </span>
                        @else
                            <span class="inline-block mt-2 px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">
                                Nonaktif
                            </span>
                        @endif
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="text-xs text-gray-500 font-semibold uppercase">Email</label>
                            <p class="text-gray-900 font-medium">{{ $customer->email }}</p>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 font-semibold uppercase">No. Telepon</label>
                            <p class="text-gray-900 font-medium">{{ $customer->phone ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 font-semibold uppercase">Alamat</label>
                            <p class="text-gray-900 font-medium">{{ $customer->address ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 font-semibold uppercase">Terdaftar</label>
                            <p class="text-gray-900 font-medium">{{ $customer->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="pt-4 border-t space-y-2">
                            <a href="{{ route('kasir.customers.edit', $customer) }}" class="block w-full px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-center transition">
                                Edit Data Pelanggan
                            </a>
                            <form action="{{ route('kasir.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold text-center transition">
                                    Hapus Pelanggan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Riwayat Transaksi</h2>
                            <p class="text-sm text-gray-600">Total {{ $transactions->total() }} transaksi</p>
                        </div>
                    </div>

                    @if($transactions->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($transactions as $transaction)
                                <div class="p-6 hover:bg-gray-50 transition">
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <h3 class="font-bold text-gray-900">{{ $transaction->transaction_code }}</h3>
                                            <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                                            @if($transaction->payment_method == 'cash')
                                                <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full font-semibold">💵 Tunai</span>
                                            @elseif($transaction->payment_method == 'debit')
                                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">💳 Debit</span>
                                            @elseif($transaction->payment_method == 'credit')
                                                <span class="text-xs px-2 py-1 bg-purple-100 text-purple-800 rounded-full font-semibold">💳 Credit</span>
                                            @else
                                                <span class="text-xs px-2 py-1 bg-orange-100 text-orange-800 rounded-full font-semibold">📱 QRIS</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase mb-2">Item Dibeli</h4>
                                        <ul class="space-y-1">
                                            @foreach($transaction->items as $item)
                                                <li class="flex justify-between text-sm">
                                                    <span class="text-gray-700">{{ $item->product_name }} x{{ $item->quantity }}</span>
                                                    <span class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-600">
                                            <span class="font-semibold">Kasir:</span> {{ $transaction->user->name }}
                                        </div>
                                        <a href="{{ route('kasir.transactions.show', $transaction) }}" class="text-primary hover:text-blue-700 font-semibold text-sm">
                                            Lihat Detail →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($transactions->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $transactions->links() }}
                            </div>
                        @endif
                    @else
                        <div class="p-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada transaksi</p>
                            <p class="text-sm text-gray-400 mt-1">Transaksi pelanggan ini akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
