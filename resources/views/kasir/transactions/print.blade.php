<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->transaction_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: 58mm auto;
            margin: 0;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            line-height: 1.4;
            width: 58mm;
            margin: 0 auto;
            padding: 5mm;
            background: white;
        }

        .receipt {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
        }

        .store-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .store-info {
            font-size: 9px;
            line-height: 1.3;
        }

        .transaction-info {
            margin: 10px 0;
            font-size: 10px;
        }

        .transaction-info div {
            margin: 2px 0;
        }

        .items-table {
            width: 100%;
            margin: 10px 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
        }

        .item-row {
            margin: 5px 0;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }

        .summary {
            margin: 10px 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .summary-row.total {
            font-weight: bold;
            font-size: 12px;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }

        .payment-info {
            margin: 10px 0;
            padding: 5px 0;
            border-top: 1px dashed #000;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            font-size: 9px;
        }

        .footer-message {
            margin: 5px 0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print" style="text-align: center; margin-bottom: 10px; padding: 10px; background: #f0f0f0;">
        <button onclick="window.print()" style="padding: 8px 20px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            🖨️ Cetak Struk
        </button>
        <button onclick="window.close()" style="padding: 8px 20px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 5px;">
            ✕ Tutup
        </button>
    </div>

    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="store-name">POSIFY</div>
            <div class="store-info">
                Sistem Kasir Modern<br>
                Jl. Contoh No. 123, Jakarta<br>
                Telp: (021) 1234-5678
            </div>
        </div>

        <!-- Transaction Info -->
        <div class="transaction-info">
            <div>No: {{ $transaction->transaction_code }}</div>
            <div>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</div>
            <div>Kasir: {{ $transaction->user->name }}</div>
            <div>Pelanggan: {{ $transaction->customer_name }}</div>
            @if($transaction->customer_phone)
                <div>Telp: {{ $transaction->customer_phone }}</div>
            @endif
        </div>

        <!-- Items -->
        <div class="items-table">
            @foreach($transaction->items as $item)
                <div class="item-row">
                    <div class="item-name">{{ $item->product_name }}</div>
                    <div class="item-details">
                        <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span class="bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($transaction->discount > 0)
                <div class="summary-row">
                    <span>Diskon</span>
                    <span>- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                </div>
            @endif
            @if($transaction->tax > 0)
                <div class="summary-row">
                    <span>Pajak</span>
                    <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="summary-row total">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment -->
        <div class="payment-info">
            <div class="summary-row">
                <span>Metode:</span>
                <span class="bold">
                    @if($transaction->payment_method === 'cash') TUNAI
                    @elseif($transaction->payment_method === 'debit') DEBIT CARD
                    @elseif($transaction->payment_method === 'credit') CREDIT CARD
                    @else QRIS
                    @endif
                </span>
            </div>
            <div class="summary-row">
                <span>Dibayar</span>
                <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row bold">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($transaction->notes)
            <div style="margin: 10px 0; font-size: 9px; padding: 5px 0; border-top: 1px dashed #000;">
                <div>Catatan: {{ $transaction->notes }}</div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div class="footer-message">
                ═══════════════════<br>
                Terima Kasih<br>
                Atas Kunjungan Anda<br>
                ═══════════════════
            </div>
            <div style="margin-top: 10px; font-size: 8px;">
                Struk ini sah sebagai bukti pembayaran<br>
                Barang yang sudah dibeli tidak dapat ditukar/dikembalikan
            </div>
            <div style="margin-top: 10px; font-size: 8px;">
                www.posify.id
            </div>
        </div>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
