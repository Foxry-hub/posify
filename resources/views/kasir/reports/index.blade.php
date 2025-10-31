<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Kasir POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-primary hover:text-blue-700 font-semibold flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">📊 Laporan Penjualan</h1>
                    <p class="text-gray-600 mt-2">Analisis dan statistik penjualan</p>
                </div>
                <a href="{{ route('kasir.reports.print', request()->all()) }}" target="_blank" class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Laporan
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Filter Laporan</h3>
            <form method="GET" action="{{ route('kasir.reports.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pelanggan</label>
                    <select name="customer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Semua Pelanggan</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Produk</label>
                    <select name="product_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Semua Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                    <select name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="debit" {{ request('payment_method') == 'debit' ? 'selected' : '' }}>Debit</option>
                        <option value="credit" {{ request('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>
                        <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="flex-1 px-6 py-2 bg-primary hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('kasir.reports.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold opacity-90">Total Transaksi</h3>
                    <svg class="w-8 h-8 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($summary['total_transactions']) }}</p>
                <p class="text-xs opacity-75 mt-1">Transaksi terjadi</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold opacity-90">Total Pendapatan</h3>
                    <svg class="w-8 h-8 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</p>
                <p class="text-xs opacity-75 mt-1">Gross revenue</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold opacity-90">Total Diskon</h3>
                    <svg class="w-8 h-8 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">Rp {{ number_format($summary['total_discount'], 0, ',', '.') }}</p>
                <p class="text-xs opacity-75 mt-1">Total diskon diberikan</p>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold opacity-90">Rata-rata Transaksi</h3>
                    <svg class="w-8 h-8 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00 2-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <p class="text-3xl font-bold">Rp {{ number_format($summary['average_transaction'], 0, ',', '.') }}</p>
                <p class="text-xs opacity-75 mt-1">Per transaksi</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Payment Method Breakdown -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Metode Pembayaran</h3>
                <div class="space-y-3">
                    @foreach($paymentBreakdown as $payment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                @if($payment->payment_method == 'cash')
                                    <span class="text-2xl">💵</span>
                                    <span class="font-semibold text-gray-700">Tunai</span>
                                @elseif($payment->payment_method == 'debit')
                                    <span class="text-2xl">💳</span>
                                    <span class="font-semibold text-gray-700">Debit Card</span>
                                @elseif($payment->payment_method == 'credit')
                                    <span class="text-2xl">💳</span>
                                    <span class="font-semibold text-gray-700">Credit Card</span>
                                @else
                                    <span class="text-2xl">📱</span>
                                    <span class="font-semibold text-gray-700">QRIS</span>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">Rp {{ number_format($payment->total, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->count }} transaksi</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">10 Produk Terlaris</h3>
                <div class="space-y-2">
                    @foreach($topProducts as $index => $item)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-3">
                                <span class="flex items-center justify-center w-8 h-8 bg-primary text-white rounded-full text-sm font-bold">{{ $index + 1 }}</span>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->total_quantity }} terjual</p>
                                </div>
                            </div>
                            <p class="font-bold text-primary">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Daily Sales Chart -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tren Penjualan Harian</h3>
            <canvas id="salesChart" height="80"></canvas>
        </div>

        <!-- Transactions List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Daftar Transaksi ({{ $transactions->total() }})</h2>
            </div>

            @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pembayaran</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-semibold text-primary">
                                        {{ $transaction->transaction_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($transaction->customer)
                                            <span class="text-blue-600 font-semibold">{{ $transaction->customer->name }}</span>
                                        @else
                                            <span class="text-gray-500">{{ $transaction->customer_name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($transaction->payment_method == 'cash')
                                            <span class="text-xs">💵 Tunai</span>
                                        @elseif($transaction->payment_method == 'debit')
                                            <span class="text-xs">💳 Debit</span>
                                        @elseif($transaction->payment_method == 'credit')
                                            <span class="text-xs">💳 Credit</span>
                                        @else
                                            <span class="text-xs">📱 QRIS</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $transactions->appends(request()->except('page'))->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <p class="text-gray-500">Tidak ada transaksi dalam periode ini</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($dailySales);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            }),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: salesData.map(item => item.total),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Jumlah Transaksi',
                data: salesData.map(item => item.count),
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.datasetIndex === 0) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            } else {
                                label += context.parsed.y + ' transaksi';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
</script>
</body>
</html>
