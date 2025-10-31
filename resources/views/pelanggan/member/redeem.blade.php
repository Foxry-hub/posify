<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukar Poin - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient shadow-sm sticky-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-store"></i> POSIFY
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pelanggan.member.index') }}">
                            <i class="fas fa-star"></i> Member
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pelanggan.transactions.index') }}">
                            <i class="fas fa-history"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="container">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 fw-bold mb-1">
                        <i class="fas fa-gift text-warning"></i> Tukar Poin
                    </h1>
                    <p class="text-muted">Pilih voucher yang ingin Anda tukarkan</p>
                </div>
                <a href="{{ route('pelanggan.member.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Point Balance -->
            <div class="card shadow-lg border-0 mb-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white text-center py-4">
                    <h5 class="opacity-75 mb-2">Poin Anda Saat Ini</h5>
                    <h1 class="display-3 fw-bold mb-0" id="currentPoints">{{ number_format($member->total_points) }}</h1>
                    <p class="opacity-75 mt-2 mb-0">Poin</p>
                </div>
            </div>

            <!-- Voucher Catalog -->
            <div class="row g-4">
                @foreach($vouchers as $voucher)
                    <div class="col-md-6 col-lg-4">
                        <div class="card voucher-card h-100 {{ $member->total_points < $voucher['points_required'] ? 'disabled' : '' }}" 
                             onclick='selectVoucher(@json($voucher), {{ $member->total_points >= $voucher['points_required'] ? 'true' : 'false' }})'>
                            <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas {{ $voucher['icon'] }} fa-3x mb-2"></i>
                                <h5 class="mb-0">{{ $voucher['name'] }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">{{ $voucher['description'] }}</p>
                                
                                @if($voucher['min_purchase'] > 0)
                                    <p class="text-sm text-muted mb-2">
                                        <i class="fas fa-shopping-cart"></i> Min. Belanja: 
                                        <strong>Rp {{ number_format($voucher['min_purchase'], 0, ',', '.') }}</strong>
                                    </p>
                                @endif

                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                    <div>
                                        <small class="text-muted">Tukar Dengan</small>
                                        <h4 class="mb-0 text-primary">{{ $voucher['points_required'] }} Poin</h4>
                                    </div>
                                    @if($member->total_points >= $voucher['points_required'])
                                        <span class="badge bg-success">Tersedia</span>
                                    @else
                                        <span class="badge bg-secondary">Kurang {{ $voucher['points_required'] - $member->total_points }} Poin</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Info Box -->
            <div class="alert alert-info mt-4">
                <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi Penting</h6>
                <ul class="mb-0">
                    <li>Voucher dapat digunakan saat transaksi berikutnya di kasir</li>
                    <li>Sebutkan kode voucher kepada kasir saat pembayaran</li>
                    <li>Poin yang sudah ditukar tidak dapat dikembalikan</li>
                    <li>Voucher berlaku sesuai syarat dan ketentuan yang tertera</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Tukar Poin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-gift fa-4x text-primary mb-3"></i>
                    <h5 id="voucherName">-</h5>
                    <p class="text-muted mb-3">Anda akan menukar <strong id="pointsNeeded">0</strong> poin</p>
                    <div class="alert alert-warning">
                        <small>Poin yang sudah ditukar tidak dapat dikembalikan</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="confirmRedeem()">
                        <i class="fas fa-check"></i> Ya, Tukar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
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
                    bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();

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
