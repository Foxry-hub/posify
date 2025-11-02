<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- JsBarcode for generating barcodes -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
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
                        <a class="nav-link active" href="{{ route('pelanggan.member.index') }}">
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
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2 fw-bold mb-1">
                        <i class="fas fa-star text-warning"></i> Member Dashboard
                    </h1>
                    <p class="text-muted">Kelola poin dan dapatkan reward menarik!</p>
                </div>
            </div>

            <!-- Member Card -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body text-white p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-id-card fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                            <p class="mb-0 opacity-75">{{ $member->member_code }}</p>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <small class="opacity-75">Member Sejak</small>
                                            <p class="mb-0 fw-bold">{{ $member->joined_date->format('d M Y') }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="opacity-75">Status</small>
                                            <p class="mb-0 fw-bold">
                                                <span class="badge bg-success">{{ ucfirst($member->status) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <small class="opacity-75">Total Poin</small>
                                        <h1 class="display-4 fw-bold mb-0">{{ number_format($member->total_points) }}</h1>
                                        <small>Lifetime: {{ number_format($member->lifetime_points) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <a href="{{ route('pelanggan.member.redeem') }}" class="btn btn-lg btn-primary mb-3">
                                <i class="fas fa-gift me-2"></i> Tukar Poin
                            </a>
                            <a href="{{ route('pelanggan.transactions.index') }}" class="btn btn-lg btn-outline-primary">
                                <i class="fas fa-shopping-cart me-2"></i> Belanja Lagi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Vouchers Section -->
            @if($activeVouchers->count() > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <h5 class="mb-0">
                            <i class="fas fa-ticket-alt"></i> Voucher Aktif Saya
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($activeVouchers as $voucher)
                                <div class="col-md-6">
                                    <div class="card border-primary shadow">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $voucher->voucher_name }}</h6>
                                                    <p class="text-muted small mb-0">Kode: <strong>{{ $voucher->voucher_code }}</strong></p>
                                                </div>
                                                <span class="badge bg-success">Aktif</span>
                                            </div>
                                            
                                            <!-- Barcode Display -->
                                            @if($voucher->barcode)
                                            <div class="text-center bg-white border rounded p-3 my-3">
                                                <svg class="barcode" 
                                                    data-barcode="{{ $voucher->barcode }}"
                                                    style="max-width: 100%; height: auto;">
                                                </svg>
                                                <p class="small text-muted mb-0 mt-1">{{ $voucher->barcode }}</p>
                                                <p class="small text-primary mb-0">
                                                    <i class="fas fa-barcode"></i> Scan barcode ini di kasir
                                                </p>
                                            </div>
                                            @endif
                                            
                                            <div class="border-top pt-2 mt-2">
                                                <div class="d-flex justify-content-between text-sm">
                                                    <span class="text-muted">Diskon:</span>
                                                    <strong>
                                                        @if($voucher->discount_type === 'percentage')
                                                            {{ $voucher->discount_value }}%
                                                        @else
                                                            Rp {{ number_format($voucher->discount_value) }}
                                                        @endif
                                                    </strong>
                                                </div>
                                                @if($voucher->min_purchase > 0)
                                                    <div class="d-flex justify-content-between text-sm">
                                                        <span class="text-muted">Min. Belanja:</span>
                                                        <strong>Rp {{ number_format($voucher->min_purchase) }}</strong>
                                                    </div>
                                                @endif
                                                <div class="d-flex justify-content-between text-sm">
                                                    <span class="text-muted">Berlaku s/d:</span>
                                                    <strong>{{ $voucher->expired_at->format('d M Y') }}</strong>
                                                </div>
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
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Poin Didapat</h6>
                                    <h3 class="mb-0 text-success">{{ number_format($totalEarned) }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-arrow-up fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Poin Ditukar</h6>
                                    <h3 class="mb-0 text-danger">{{ number_format($totalRedeemed) }}</h3>
                                </div>
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-arrow-down fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Segera Hangus</h6>
                                    <h3 class="mb-0 text-warning">{{ number_format($expiringPoints) }}</h3>
                                    <small class="text-muted">dalam 30 hari</small>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Point History -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Poin</h5>
                </div>
                <div class="card-body p-0">
                    @if($pointHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Transaksi</th>
                                        <th class="text-center">Poin</th>
                                        <th class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pointHistory as $point)
                                        <tr>
                                            <td>
                                                <small class="text-muted">{{ $point->created_at->format('d M Y') }}</small><br>
                                                <small class="text-muted">{{ $point->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $point->description }}</strong>
                                                @if($point->expired_at && $point->type == 'earned')
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-clock"></i> 
                                                        Berlaku s/d {{ $point->expired_at->format('d M Y') }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($point->transaction)
                                                    <span class="badge bg-secondary">{{ $point->transaction->transaction_code }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($point->type == 'earned')
                                                    <span class="badge bg-success">+{{ $point->points }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $point->points }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if($point->type == 'earned')
                                                    <span class="badge bg-success-subtle text-success">Didapat</span>
                                                @elseif($point->type == 'redeemed')
                                                    <span class="badge bg-danger-subtle text-danger">Ditukar</span>
                                                @elseif($point->type == 'expired')
                                                    <span class="badge bg-warning-subtle text-warning">Hangus</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="p-3">
                            {{ $pointHistory->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada riwayat poin</p>
                            <a href="{{ route('pelanggan.transactions.index') }}" class="btn btn-primary">
                                Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Box -->
            <div class="card border-primary mt-4">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-info-circle text-primary"></i> Cara Mendapat Poin</h6>
                    <ul class="mb-0">
                        <li>Belanja minimal Rp 10.000 untuk mendapat 1 poin</li>
                        <li>Sebutkan nomor HP Anda saat transaksi di kasir</li>
                        <li>Poin otomatis masuk ke akun Anda</li>
                        <li>Poin berlaku selama 1 tahun sejak didapat</li>
                        <li>Tukar poin dengan voucher & diskon menarik!</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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
