<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Member;
use App\Models\MemberVoucher;

echo "=== TESTING VOUCHER SYSTEM ===\n\n";

// Check Rafa's member
$rafa = User::where('phone', '081388088171')->first();

if (!$rafa) {
    echo "ERROR: Rafa tidak ditemukan!\n";
    exit(1);
}

echo "User: {$rafa->name}\n";
echo "Phone: {$rafa->phone}\n";

$member = $rafa->member;

if (!$member) {
    echo "ERROR: Rafa belum menjadi member!\n";
    exit(1);
}

echo "Member Code: {$member->member_code}\n";
echo "Total Points: {$member->total_points}\n";
echo "Lifetime Points: {$member->lifetime_points}\n\n";

// Check vouchers
echo "=== VOUCHERS ===\n";
$vouchers = MemberVoucher::where('member_id', $member->id)->get();

if ($vouchers->count() > 0) {
    foreach ($vouchers as $voucher) {
        echo "Code: {$voucher->voucher_code}\n";
        echo "  Name: {$voucher->voucher_name}\n";
        echo "  Type: {$voucher->voucher_type}\n";
        echo "  Discount: ";
        if ($voucher->discount_type === 'percentage') {
            echo "{$voucher->discount_value}%\n";
        } else {
            echo "Rp " . number_format($voucher->discount_value) . "\n";
        }
        echo "  Min Purchase: Rp " . number_format($voucher->min_purchase) . "\n";
        echo "  Status: {$voucher->status}\n";
        echo "  Expired At: {$voucher->expired_at->format('d M Y H:i')}\n";
        echo "  Points Used: {$voucher->points_used}\n";
        if ($voucher->used_at) {
            echo "  Used At: {$voucher->used_at->format('d M Y H:i')}\n";
        }
        echo "\n";
    }
} else {
    echo "No vouchers found.\n";
    echo "\nℹ️  Silakan redeem voucher terlebih dahulu di:\n";
    echo "   http://127.0.0.1:8000/pelanggan/member/redeem\n";
    echo "   Login dengan: 081388088171 / 081388088171\n";
}

echo "\n=== SUMMARY ===\n";
echo "Active Vouchers: " . $vouchers->where('status', 'active')->count() . "\n";
echo "Used Vouchers: " . $vouchers->where('status', 'used')->count() . "\n";
echo "Expired Vouchers: " . $vouchers->where('status', 'expired')->count() . "\n";
