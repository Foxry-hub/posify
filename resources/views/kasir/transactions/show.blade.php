<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - {{ $transaction->transaction_code }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('kasir.transactions.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('kasir.transactions.print', $transaction) }}" target="_blank" class="px-4 py-2 bg-primary hover:bg-blue-600 text-white rounded-lg font-semibold transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Struk
                </a>
            </div>

            <!-- Transaction Details -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-primary to-blue-600 text-white p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold mb-2">Detail Transaksi</h1>
                            <p class="text-blue-100">{{ $transaction->transaction_code }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-blue-100">{{ $transaction->created_at->format('d F Y') }}</p>
                            <p class="text-sm text-blue-100">{{ $transaction->created_at->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Customer Info -->
                    <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Kasir</h3>
                            <p class="text-lg font-semibold text-gray-900">{{ $transaction->user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Pelanggan</h3>
                            <p class="text-lg font-semibold text-gray-900">{{ $transaction->customer_name }}</p>
                            @if($transaction->customer_phone)
                                <p class="text-sm text-gray-600">{{ $transaction->customer_phone }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Barang</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transaction->items as $item)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="text-sm text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="text-sm font-semibold text-gray-900">{{ $item->quantity }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if($transaction->discount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Diskon</span>
                                    <span class="font-semibold text-red-600">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            @if($transaction->tax > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Pajak</span>
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="border-t pt-3 flex justify-between">
                                <span class="text-lg font-bold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between text-sm">
                                <span class="text-gray-600">Dibayar</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kembalian</span>
                                <span class="font-bold text-green-600 text-lg">Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Metode Pembayaran</span>
                                @if($transaction->payment_method === 'cash')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Tunai</span>
                                @elseif($transaction->payment_method === 'debit')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Debit Card</span>
                                @elseif($transaction->payment_method === 'credit')
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">Credit Card</span>
                                @else
                                    <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-semibold">QRIS</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($transaction->notes)
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-700 mb-1">Catatan:</h4>
                            <p class="text-sm text-gray-600">{{ $transaction->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
