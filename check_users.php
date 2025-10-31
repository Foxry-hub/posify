<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\Member;

echo "=== ALL PELANGGAN USERS ===\n";
$users = User::where('role', 'pelanggan')->get();
foreach ($users as $user) {
    $transactions = Transaction::where('customer_id', $user->id)->count();
    $isMember = $user->member ? 'YES (ID: ' . $user->member->id . ')' : 'NO';
    echo "ID: {$user->id} | Name: {$user->name} | Phone: {$user->phone} | Transactions: {$transactions} | Member: {$isMember}\n";
}

echo "\n=== ALL MEMBERS ===\n";
$members = Member::with('user')->get();
foreach ($members as $member) {
    echo "Member ID: {$member->id} | Code: {$member->member_code} | User: {$member->user->name} | User ID: {$member->user_id} | Points: {$member->total_points}\n";
}

echo "\n=== ALL TRANSACTIONS ===\n";
$transactions = Transaction::with('customer')->get();
foreach ($transactions as $trans) {
    $customerName = $trans->customer ? $trans->customer->name : 'GUEST';
    echo "Code: {$trans->transaction_code} | Customer ID: {$trans->customer_id} | Name: {$customerName} | Total: Rp " . number_format($trans->total) . "\n";
}
