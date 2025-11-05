<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- JsBarcode for generating barcodes -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
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
                    <a href="{{ route('pelanggan.member.index') }}" class="text-primary font-semibold border-b-2 border-primary pb-1">
                        Member
                    </a>
                    <a href="{{ route('pelanggan.transactions.index') }}" class="text-gray-700 hover:text-primary transition">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <!-- Header -->
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-star text-yellow-500"></i> Member Dashboard
            </h1>
            <p class="text-gray-600">Kelola poin dan dapatkan reward menarik!</p>
        </div>

        <!-- Member Card -->
        <div class="grid lg:grid-cols-3 gap-6 mb-6 md:mb-8">
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-primary to-red-600 rounded-2xl shadow-lg p-6 md:p-8 text-white">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center mb-4">
                                <div class="bg-white bg-opacity-25 rounded-full p-3 mr-4">
                                    <i class="fas fa-id-card text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="text-xl font-bold mb-1">{{ Auth::user()->name }}</h5>
                                    <p class="opacity-75">{{ $member->member_code }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <small class="opacity-75 block">Member Sejak</small>
                                    <p class="font-bold">{{ $member->joined_date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <small class="opacity-75 block">Status</small>
                                    <p class="font-bold">
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">{{ ucfirst($member->status) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl p-6 text-center min-w-[200px]">
                            <small class="text-blue-600 font-semibold block mb-2">Total Poin</small>
                            <h1 class="text-5xl font-bold mb-1 text-blue-600">{{ number_format($member->total_points) }}</h1>
                            <small class="text-gray-600">Lifetime: {{ number_format($member->lifetime_points) }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div>
                <div class="bg-white rounded-2xl shadow-lg p-6 h-full flex flex-col justify-center gap-4">
                    <a href="{{ route('pelanggan.member.redeem') }}" 
                       class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-4 rounded-lg hover:shadow-lg transition text-center flex items-center justify-center gap-2">
                        <i class="fas fa-gift"></i> Tukar Poin
                    </a>
                    <a href="{{ route('pelanggan.transactions.index') }}" 
                       class="border-2 border-primary text-primary px-6 py-4 rounded-lg hover:bg-primary hover:text-white transition text-center flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-cart"></i> Belanja Lagi
                    </a>
                </div>
            </div>
        </div>

        <!-- Active Vouchers Section -->
        @if($activeVouchers->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white px-6 py-4">
                    <h5 class="text-lg font-semibold flex items-center gap-2">
                        <i class="fas fa-ticket-alt"></i> Voucher Aktif Saya
                    </h5>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($activeVouchers as $voucher)
                            <div class="border-2 border-primary rounded-xl shadow-md">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h6 class="font-bold text-lg mb-1">{{ $voucher->voucher_name }}</h6>
                                            <p class="text-gray-600 text-sm">Kode: <strong>{{ $voucher->voucher_code }}</strong></p>
                                        </div>
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Aktif</span>
                                    </div>
                                    
                                    <!-- Barcode Display -->
                                    @if($voucher->barcode)
                                    <div class="text-center bg-white border-2 border-gray-200 rounded-lg p-4 my-4">
                                        <svg class="barcode mx-auto" 
                                            data-barcode="{{ $voucher->barcode }}"
                                            style="max-width: 100%; height: auto;">
                                        </svg>
                                        <p class="text-sm text-gray-500 mt-2">{{ $voucher->barcode }}</p>
                                        <p class="text-sm text-primary mt-1">
                                            <i class="fas fa-barcode"></i> Scan barcode ini di kasir
                                        </p>
                                    </div>
                                    @endif
                                    
                                    <div class="border-t-2 border-gray-100 pt-3 mt-3 space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Diskon:</span>
                                            <strong>
                                                @if($voucher->discount_type === 'percentage')
                                                    {{ $voucher->discount_value }}%
                                                @else
                                                    Rp {{ number_format($voucher->discount_value) }}
                                                @endif
                                            </strong>
                                        </div>
                                        @if($voucher->min_purchase > 0)
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Min. Belanja:</span>
                                                <strong>Rp {{ number_format($voucher->min_purchase) }}</strong>
                                            </div>
                                        @endif
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Berlaku s/d:</span>
                                            <strong>{{ $voucher->expired_at->format('d M Y') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h6 class="text-gray-600 text-sm mb-2">Poin Didapat</h6>
                        <h3 class="text-3xl font-bold text-green-600">{{ number_format($totalEarned) }}</h3>
                    </div>
                    <div class="bg-green-100 rounded-full p-4">
                        <i class="fas fa-arrow-up text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h6 class="text-gray-600 text-sm mb-2">Poin Ditukar</h6>
                        <h3 class="text-3xl font-bold text-red-600">{{ number_format($totalRedeemed) }}</h3>
                    </div>
                    <div class="bg-red-100 rounded-full p-4">
                        <i class="fas fa-arrow-down text-2xl text-red-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h6 class="text-gray-600 text-sm mb-2">Segera Hangus</h6>
                        <h3 class="text-3xl font-bold text-yellow-600">{{ number_format($expiringPoints) }}</h3>
                        <small class="text-gray-500">dalam 30 hari</small>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-4">
                        <i class="fas fa-clock text-2xl text-yellow-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Point History -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-4">
                <h5 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fas fa-history"></i> Riwayat Poin
                </h5>
            </div>
            <div class="p-0">
                @if($pointHistory->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-3 px-6 font-semibold text-gray-700">Tanggal</th>
                                    <th class="text-left py-3 px-6 font-semibold text-gray-700">Deskripsi</th>
                                    <th class="text-left py-3 px-6 font-semibold text-gray-700">Transaksi</th>
                                    <th class="text-center py-3 px-6 font-semibold text-gray-700">Poin</th>
                                    <th class="text-right py-3 px-6 font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pointHistory as $point)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                        <td class="py-3 px-6">
                                            <small class="text-gray-600 block">{{ $point->created_at->format('d M Y') }}</small>
                                            <small class="text-gray-500">{{ $point->created_at->format('H:i') }}</small>
                                        </td>
                                        <td class="py-3 px-6">
                                            <strong>{{ $point->description }}</strong>
                                            @if($point->expired_at && $point->type == 'earned')
                                                <br><small class="text-gray-500">
                                                    <i class="fas fa-clock"></i> 
                                                    Berlaku s/d {{ $point->expired_at->format('d M Y') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6">
                                            @if($point->transaction)
                                                <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm">{{ $point->transaction->transaction_code }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            @if($point->type == 'earned')
                                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">+{{ $point->points }}</span>
                                            @else
                                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">{{ $point->points }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-right">
                                            @if($point->type == 'earned')
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Didapat</span>
                                            @elseif($point->type == 'redeemed')
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Ditukar</span>
                                            @elseif($point->type == 'expired')
                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Hangus</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-6">
                        {{ $pointHistory->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 mb-4">Belum ada riwayat poin</p>
                        <a href="{{ route('pelanggan.transactions.index') }}" 
                           class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition inline-flex items-center gap-2">
                            Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-white border-2 border-primary rounded-2xl shadow-lg p-6">
            <h6 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-primary"></i> Cara Mendapat Poin
            </h6>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-green-500 mt-1"></i>
                    <span>Belanja minimal Rp 10.000 untuk mendapat 1 poin</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-green-500 mt-1"></i>
                    <span>Sebutkan nomor HP Anda saat transaksi di kasir</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-green-500 mt-1"></i>
                    <span>Poin otomatis masuk ke akun Anda</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-green-500 mt-1"></i>
                    <span>Poin berlaku selama 1 tahun sejak didapat</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check text-green-500 mt-1"></i>
                    <span>Tukar poin dengan voucher & diskon menarik!</span>
                </li>
            </ul>
        </div>
    </div>
</div>

    <!-- Generate Barcodes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Generate all barcodes
            document.querySelectorAll('.barcode').forEach(function(svg) {
                const barcodeValue = svg.getAttribute('data-barcode');
                if (barcodeValue) {
                    JsBarcode(svg, barcodeValue, {
                        format: "CODE128",
                        width: 2,
                        height: 60,
                        displayValue: false,
                        margin: 10
                    });
                }
            });
        });
    </script>
</body>
</html>
