<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - {{ $transaction->transaction_code }} - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                POSIFY
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('pelanggan.transactions.index') }}">
                            Riwayat Belanja
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

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Transaksi</h1>
        <a href="{{ route('pelanggan.transactions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Transaction Info -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold" style="width: 40%;">Kode Transaksi:</td>
                            <td>
                                <span class="badge bg-secondary">{{ $transaction->transaction_code }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal:</td>
                            <td>{{ $transaction->created_at->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Waktu:</td>
                            <td>{{ $transaction->created_at->format('H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kasir:</td>
                            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Metode Pembayaran:</td>
                            <td>
                                @if($transaction->payment_method == 'cash')
                                    <span class="badge bg-success">Cash</span>
                                @elseif($transaction->payment_method == 'debit')
                                    <span class="badge bg-primary">Debit</span>
                                @elseif($transaction->payment_method == 'credit')
                                    <span class="badge bg-warning">Credit</span>
                                @elseif($transaction->payment_method == 'qris')
                                    <span class="badge bg-info">QRIS</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave"></i> Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold">Subtotal:</td>
                            <td class="text-end">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if($transaction->discount > 0)
                        <tr>
                            <td class="fw-bold text-danger">Diskon:</td>
                            <td class="text-end text-danger">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        @if($transaction->tax > 0)
                        <tr>
                            <td class="fw-bold">Pajak:</td>
                            <td class="text-end">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr class="border-top">
                            <td class="fw-bold fs-5">Total:</td>
                            <td class="text-end fw-bold fs-5 text-success">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dibayar:</td>
                            <td class="text-end">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kembalian:</td>
                            <td class="text-end">Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Transaction Items -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Detail Barang</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 40%;">Nama Produk</th>
                                    <th style="width: 15%;" class="text-center">Jumlah</th>
                                    <th style="width: 20%;" class="text-end">Harga Satuan</th>
                                    <th style="width: 20%;" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaction->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                            @if($item->product->code)
                                                <small class="text-muted">Kode: {{ $item->product->code }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            <i class="fas fa-box-open"></i> Tidak ada item
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($transaction->items->count() > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Total Item:</td>
                                    <td class="text-end fw-bold">
                                        {{ $transaction->items->sum('quantity') }} pcs
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold fs-5">Grand Total:</td>
                                    <td class="text-end fw-bold fs-5 text-success">
                                        Rp {{ number_format($transaction->items->sum('subtotal'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>

                    @if($transaction->notes)
                    <div class="mt-3">
                        <div class="alert alert-secondary mb-0">
                            <strong><i class="fas fa-sticky-note"></i> Catatan:</strong><br>
                            {{ $transaction->notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-info-circle"></i> 
                        Transaksi ini dilakukan pada {{ $transaction->created_at->format('d F Y') }} pukul {{ $transaction->created_at->format('H:i:s') }}
                        @if($transaction->updated_at != $transaction->created_at)
                            <br>Terakhir diperbarui pada {{ $transaction->updated_at->format('d F Y H:i:s') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
