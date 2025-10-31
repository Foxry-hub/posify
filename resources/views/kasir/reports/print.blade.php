<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - {{ $startDate }} s/d {{ $endDate }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }
        .period {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .summary-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .summary-card h3 {
            font-size: 11px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .summary-card p {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            background: #f0f0f0;
            font-weight: bold;
            border-top: 2px solid #333;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .print-button:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">🖨️ Cetak Laporan</button>

    <div class="header">
        <h1>POSIFY</h1>
        <h2>Laporan Penjualan</h2>
        <p>Point of Sale Management System</p>
    </div>

    <div class="period">
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
    </div>

    <div class="summary">
        <div class="summary-card">
            <h3>Total Transaksi</h3>
            <p>{{ number_format($summary['total_transactions']) }}</p>
        </div>
        <div class="summary-card">
            <h3>Total Pendapatan</h3>
            <p>Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h3>Total Diskon</h3>
            <p>Rp {{ number_format($summary['total_discount'], 0, ',', '.') }}</p>
        </div>
    </div>

    <h3 style="margin-top: 30px; margin-bottom: 10px; font-size: 16px;">Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 18%;">Kode Transaksi</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%;">Pelanggan</th>
                <th style="width: 12%;">Pembayaran</th>
                <th style="width: 12%;" class="text-right">Diskon</th>
                <th style="width: 18%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $transaction)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold;">{{ $transaction->transaction_code }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($transaction->customer)
                            {{ $transaction->customer->name }}
                        @else
                            {{ $transaction->customer_name }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if($transaction->payment_method == 'cash')
                            Tunai
                        @elseif($transaction->payment_method == 'debit')
                            Debit
                        @elseif($transaction->payment_method == 'credit')
                            Credit
                        @else
                            QRIS
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: bold;">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($summary['total_discount'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>© {{ date('Y') }} POSIFY - Point of Sale Management System</p>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            // Uncomment if you want auto print
            // window.print();
        }
    </script>
</body>
</html>
