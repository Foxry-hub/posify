<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Transaction;
use App\Models\TransactionItem;

echo "=== TRANSACTION DETAILS ===\n\n";

$transaction = Transaction::where('transaction_code', 'TRX-20251030-HMGPOZ')->first();

if ($transaction) {
    echo "Code: {$transaction->transaction_code}\n";
    echo "Customer ID: {$transaction->customer_id}\n";
    echo "Total Amount: Rp " . number_format($transaction->total_amount) . "\n";
    echo "Payment Method: {$transaction->payment_method}\n";
    echo "Status: {$transaction->status}\n";
    echo "Date: {$transaction->created_at}\n\n";
    
    echo "=== ITEMS ===\n";
    $items = TransactionItem::where('transaction_id', $transaction->id)->get();
    
    if ($items->count() > 0) {
        foreach ($items as $item) {
            echo "- {$item->product_name} x {$item->quantity} = Rp " . number_format($item->subtotal) . "\n";
        }
    } else {
        echo "No items found!\n";
    }
} else {
    echo "Transaction not found!\n";
}
