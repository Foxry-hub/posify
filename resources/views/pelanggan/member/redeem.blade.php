<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukar Poin - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .voucher-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .voucher-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .voucher-card.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .voucher-card.disabled:hover {
            transform: none;
        }
    </style>
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
                    <a href="{{ route('pelanggan.member.index') }}" class="text-gray-700 hover:text-primary transition">
                        Member
                    </a>
                    <a href="{{ route('pelanggan.transactions.index') }}" class="text-gray-700 hover:text-primary transition">
                        Riwayat
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
        <div class="flex justify-between items-center mb-6 md:mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-gift text-yellow-500"></i> Tukar Poin
                </h1>
                <p class="text-gray-600">Pilih voucher yang ingin Anda tukarkan</p>
            </div>
            <a href="{{ route('pelanggan.member.index') }}" 
               class="bg-gradient-to-br from-gray-500 to-gray-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Point Balance -->
        <div class="bg-gradient-to-br from-pink-500 to-red-600 rounded-2xl shadow-lg text-white text-center py-8 mb-6 md:mb-8">
            <h5 class="opacity-75 mb-3 text-lg">Poin Anda Saat Ini</h5>
            <h1 class="text-6xl font-bold mb-2" id="currentPoints">{{ number_format($member->total_points) }}</h1>
            <p class="opacity-75">Poin</p>
        </div>

        <!-- Voucher Catalog -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vouchers as $voucher)
                <div class="voucher-card bg-white rounded-2xl shadow-lg overflow-hidden h-full {{ $member->total_points < $voucher['points_required'] ? 'disabled' : '' }}" 
                     onclick='selectVoucher(@json($voucher), {{ $member->total_points >= $voucher['points_required'] ? 'true' : 'false' }})'>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white text-center py-6">
                        <i class="fas {{ $voucher['icon'] }} text-5xl mb-3"></i>
                        <h5 class="font-bold text-lg">{{ $voucher['name'] }}</h5>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">{{ $voucher['description'] }}</p>
                        
                        @if($voucher['min_purchase'] > 0)
                            <p class="text-sm text-gray-600 mb-3 flex items-center gap-2">
                                <i class="fas fa-shopping-cart"></i> Min. Belanja: 
                                <strong>Rp {{ number_format($voucher['min_purchase'], 0, ',', '.') }}</strong>
                            </p>
                        @endif

                        <div class="flex justify-between items-center mt-4 pt-4 border-t-2 border-gray-100">
                            <div>
                                <small class="text-gray-500 block">Tukar Dengan</small>
                                <h4 class="text-2xl font-bold text-primary">{{ $voucher['points_required'] }} Poin</h4>
                            </div>
                            @if($member->total_points >= $voucher['points_required'])
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Tersedia</span>
                            @else
                                <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm">Kurang {{ $voucher['points_required'] - $member->total_points }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Info Box -->
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 px-6 py-4 rounded-lg shadow mt-6 md:mt-8">
            <h6 class="font-bold mb-3 flex items-center gap-2">
                <i class="fas fa-info-circle"></i> Informasi Penting
            </h6>
            <ul class="space-y-2 ml-4">
                <li>Voucher dapat digunakan saat transaksi berikutnya di kasir</li>
                <li>Sebutkan kode voucher kepada kasir saat pembayaran</li>
                <li>Poin yang sudah ditukar tidak dapat dikembalikan</li>
                <li>Voucher berlaku sesuai syarat dan ketentuan yang tertera</li>
            </ul>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4">
            <div class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-4 rounded-t-2xl">
                <h5 class="text-lg font-semibold">Konfirmasi Tukar Poin</h5>
            </div>
            <div class="p-6 text-center">
                <i class="fas fa-gift text-5xl text-primary mb-4"></i>
                <h5 class="text-xl font-bold mb-2" id="voucherName">-</h5>
                <p class="text-gray-600 mb-4">Anda akan menukar <strong id="pointsNeeded">0</strong> poin</p>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 px-4 py-3 rounded">
                    <small>Poin yang sudah ditukar tidak dapat dikembalikan</small>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button type="button" class="flex-1 bg-gradient-to-br from-gray-500 to-gray-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition" onclick="closeModal()">
                    Batal
                </button>
                <button type="button" class="flex-1 bg-gradient-to-br from-primary to-red-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition" onclick="confirmRedeem()">
                    <i class="fas fa-check"></i> Ya, Tukar Sekarang
                </button>
            </div>
        </div>
    </div>

    <script>
        let selectedVoucher = null;

        function selectVoucher(voucher, canRedeem) {
            if (canRedeem !== true) {
                alert('Poin Anda tidak cukup untuk menukar voucher ini!');
                return;
            }

            selectedVoucher = voucher;

            document.getElementById('voucherName').textContent = voucher.name;
            document.getElementById('pointsNeeded').textContent = voucher.points_required;

            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        async function confirmRedeem() {
            if (!selectedVoucher) return;

            try {
                const response = await fetch('{{ route('pelanggan.member.redeem.process') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        voucher_id: selectedVoucher.id,
                        voucher_name: selectedVoucher.name,
                        points: selectedVoucher.points_required,
                        discount_type: selectedVoucher.discount_type,
                        discount_value: selectedVoucher.discount_value,
                        min_purchase: selectedVoucher.min_purchase
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Close modal
                    closeModal();

                    // Update points display
                    document.getElementById('currentPoints').textContent = data.remaining_points.toLocaleString('id-ID');

                    // Show success message with voucher code
                    alert('✅ ' + data.message + '\n\nKode Voucher: ' + data.voucher_code + '\n\nVoucher dapat dilihat di halaman Member.\nTunjukkan ke kasir saat transaksi.');

                    // Reload page after 2 seconds
                    setTimeout(() => {
                        window.location.href = '{{ route('pelanggan.member.index') }}';
                    }, 2000);
                } else {
                    alert('❌ ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        }
    </script>
</body>
</html>
