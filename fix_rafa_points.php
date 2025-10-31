<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\MemberPoint;
use Illuminate\Support\Facades\DB;

echo "=== FIXING RAFA'S POINTS ===\n\n";

DB::beginTransaction();

try {
    // Get Rafa's user and member
    $rafaUser = User::where('phone', '081388088171')->first();
    
    if (!$rafaUser) {
        echo "ERROR: User Rafa tidak ditemukan!\n";
        exit(1);
    }
    
    echo "User found: {$rafaUser->name} (ID: {$rafaUser->id})\n";
    
    $rafaMember = $rafaUser->member;
    
    if (!$rafaMember) {
        echo "ERROR: Member Rafa tidak ditemukan!\n";
        exit(1);
    }
    
    echo "Member found: {$rafaMember->member_code} (ID: {$rafaMember->id})\n\n";
    
    // Get all transactions for this user
    $transactions = Transaction::where('customer_id', $rafaUser->id)->get();
    
    echo "Found {$transactions->count()} transaction(s)\n\n";
    
    foreach ($transactions as $transaction) {
        // Check if points already added for this transaction
        $existingPoints = MemberPoint::where('member_id', $rafaMember->id)
            ->where('transaction_id', $transaction->id)
            ->where('type', 'earned')
            ->first();
        
        if ($existingPoints) {
            echo "Transaction {$transaction->transaction_code} - Points already added, skipping\n";
            continue;
        }
        
        // Add points for this transaction
        $pointsEarned = $rafaMember->addPointsFromTransaction($transaction);
        
        echo "Transaction {$transaction->transaction_code}:\n";
        echo "  - Total: Rp " . number_format($transaction->total_amount) . "\n";
        echo "  - Points earned: {$pointsEarned}\n\n";
    }
    
    // Refresh member to get updated points
    $rafaMember->refresh();
    
    echo "=== SUMMARY ===\n";
    echo "Total Points: {$rafaMember->total_points}\n";
    echo "Lifetime Points: {$rafaMember->lifetime_points}\n";
    
    DB::commit();
    echo "\n✅ SUCCESS! Points have been added.\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
