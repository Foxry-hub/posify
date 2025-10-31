<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

echo "=== FIXING TRANSACTION TOTAL ===\n\n";

DB::beginTransaction();

try {
    $transaction = Transaction::where('transaction_code', 'TRX-20251030-HMGPOZ')->first();
    
    if (!$transaction) {
        echo "ERROR: Transaction not found!\n";
        exit(1);
    }
    
    // Calculate correct total from items
    $correctTotal = TransactionItem::where('transaction_id', $transaction->id)->sum('subtotal');
    
    echo "Transaction: {$transaction->transaction_code}\n";
    echo "Old Total: Rp " . number_format($transaction->total) . "\n";
    echo "Correct Total: Rp " . number_format($correctTotal) . "\n\n";
    
    // Update transaction total
    $transaction->total = $correctTotal;
    $transaction->save();
    
    echo "✅ Transaction total updated!\n\n";
    
    // Now add points if user is a member
    if ($transaction->customer_id) {
        $member = Member::where('user_id', $transaction->customer_id)->first();
        
        if ($member && $member->isActive()) {
            // Check if points already exist
            $existingPoints = $member->points()
                ->where('transaction_id', $transaction->id)
                ->where('type', 'earned')
                ->first();
            
            if (!$existingPoints) {
                $pointsEarned = $member->addPointsFromTransaction($transaction);
                echo "✅ Points added: {$pointsEarned} points\n";
                
                $member->refresh();
                echo "Member total points: {$member->total_points}\n";
            } else {
                echo "ℹ️  Points already exist for this transaction\n";
            }
        }
    }
    
    DB::commit();
    echo "\n✅ SUCCESS! Transaction and points fixed.\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
