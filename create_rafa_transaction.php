<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

echo "=== CREATE NEW TRANSACTION FOR RAFA ===\n\n";

DB::beginTransaction();

try {
    // Get Rafa's user
    $rafaUser = User::where('phone', '081388088171')->first();
    
    if (!$rafaUser) {
        echo "ERROR: User Rafa tidak ditemukan!\n";
        exit(1);
    }
    
    echo "Customer: {$rafaUser->name} (ID: {$rafaUser->id})\n";
    
    // Get kasir user (assume first kasir)
    $kasir = User::where('role', 'kasir')->first();
    
    if (!$kasir) {
        echo "ERROR: Kasir tidak ditemukan!\n";
        exit(1);
    }
    
    echo "Kasir: {$kasir->name} (ID: {$kasir->id})\n\n";
    
    // Get some products
    $products = Product::take(3)->get();
    
    if ($products->count() < 1) {
        echo "ERROR: Tidak ada produk!\n";
        exit(1);
    }
    
    // Create transaction
    $transaction = Transaction::create([
        'transaction_code' => 'TRX-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
        'user_id' => $kasir->id,
        'customer_id' => $rafaUser->id,
        'customer_name' => $rafaUser->name,
        'customer_phone' => $rafaUser->phone,
        'subtotal' => 0,
        'discount' => 0,
        'tax' => 0,
        'total' => 0,
        'paid_amount' => 0,
        'change' => 0,
        'payment_method' => 'cash',
        'status' => 'completed',
    ]);
    
    echo "Transaction created: {$transaction->transaction_code}\n";
    
    // Add items
    $subtotal = 0;
    foreach ($products as $index => $product) {
        $quantity = $index + 2; // 2, 3, 4 items
        $itemSubtotal = $product->price * $quantity;
        
        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $product->price,
            'subtotal' => $itemSubtotal,
        ]);
        
        $subtotal += $itemSubtotal;
        echo "  - {$product->name} x {$quantity} = Rp " . number_format($itemSubtotal) . "\n";
    }
    
    // Update transaction totals
    $transaction->subtotal = $subtotal;
    $transaction->total = $subtotal;
    $transaction->paid_amount = ceil($subtotal / 1000) * 1000; // Round up to nearest 1000
    $transaction->change = $transaction->paid_amount - $transaction->total;
    $transaction->save();
    
    echo "\nTransaction Summary:\n";
    echo "  Subtotal: Rp " . number_format($transaction->subtotal) . "\n";
    echo "  Total: Rp " . number_format($transaction->total) . "\n";
    echo "  Paid: Rp " . number_format($transaction->paid_amount) . "\n";
    echo "  Change: Rp " . number_format($transaction->change) . "\n\n";
    
    // Add points if member
    $member = $rafaUser->member;
    
    if ($member && $member->isActive()) {
        $pointsEarned = $member->addPointsFromTransaction($transaction);
        echo "✅ Member points earned: {$pointsEarned} poin\n";
        
        $member->refresh();
        echo "Total points: {$member->total_points}\n";
    } else {
        echo "ℹ️  Customer is not a member\n";
    }
    
    DB::commit();
    echo "\n✅ SUCCESS! New transaction created.\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
