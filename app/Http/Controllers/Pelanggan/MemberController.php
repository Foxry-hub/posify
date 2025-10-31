<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberPoint;
use App\Models\MemberVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Tampilkan dashboard member
     */
    public function index()
    {
        $user = Auth::user();
        
        // Cek apakah user adalah member
        if (!$user->member) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai member.');
        }

        $member = $user->member;
        
        // Get point history
        $pointHistory = $member->points()
            ->with('transaction')
            ->latest()
            ->paginate(15);

        // Get active vouchers
        $activeVouchers = $member->vouchers()
            ->where('status', 'active')
            ->where('expired_at', '>', now())
            ->latest()
            ->get();

        // Get statistics
        $totalEarned = $member->points()->where('type', 'earned')->sum('points');
        $totalRedeemed = abs($member->points()->where('type', 'redeemed')->sum('points'));
        $expiringPoints = $member->points()
            ->where('type', 'earned')
            ->where('expired_at', '<=', now()->addDays(30))
            ->where('expired_at', '>', now())
            ->sum('points');

        return view('pelanggan.member.index', compact(
            'member',
            'pointHistory',
            'activeVouchers',
            'totalEarned',
            'totalRedeemed',
            'expiringPoints'
        ));
    }

    /**
     * Tampilkan halaman tukar poin
     */
    public function redeemPage()
    {
        $user = Auth::user();
        
        if (!$user->member) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai member.');
        }

        $member = $user->member;
        
        // Voucher catalog (bisa dipindah ke database nanti)
        $vouchers = [
            [
                'id' => 'discount_5',
                'name' => 'Diskon 5%',
                'description' => 'Diskon 5% untuk pembelian minimal Rp 50.000',
                'points_required' => 50,
                'discount_type' => 'percentage',
                'discount_value' => 5,
                'min_purchase' => 50000,
                'icon' => 'fa-tag',
                'color' => 'blue',
            ],
            [
                'id' => 'discount_10',
                'name' => 'Diskon 10%',
                'description' => 'Diskon 10% untuk pembelian minimal Rp 100.000',
                'points_required' => 100,
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'min_purchase' => 100000,
                'icon' => 'fa-tags',
                'color' => 'green',
            ],
            [
                'id' => 'cashback_10k',
                'name' => 'Cashback Rp 10.000',
                'description' => 'Potongan langsung Rp 10.000 untuk pembelian minimal Rp 15.000',
                'points_required' => 150,
                'discount_type' => 'fixed',
                'discount_value' => 10000,
                'min_purchase' => 15000, // Cashback + 5000
                'icon' => 'fa-money-bill-wave',
                'color' => 'yellow',
            ],
            [
                'id' => 'discount_15',
                'name' => 'Diskon 15%',
                'description' => 'Diskon 15% untuk pembelian minimal Rp 200.000',
                'points_required' => 200,
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'min_purchase' => 200000,
                'icon' => 'fa-gift',
                'color' => 'purple',
            ],
            [
                'id' => 'cashback_25k',
                'name' => 'Cashback Rp 25.000',
                'description' => 'Potongan langsung Rp 25.000 untuk pembelian minimal Rp 30.000',
                'points_required' => 300,
                'discount_type' => 'fixed',
                'discount_value' => 25000,
                'min_purchase' => 30000, // Cashback + 5000
                'icon' => 'fa-coins',
                'color' => 'red',
            ],
        ];

        return view('pelanggan.member.redeem', compact('member', 'vouchers'));
    }

    /**
     * Proses tukar poin
     */
    public function redeem(Request $request)
    {
        $validated = $request->validate([
            'voucher_id' => 'required|string',
            'voucher_name' => 'required|string',
            'points' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric',
            'min_purchase' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $member = $user->member;

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum terdaftar sebagai member.',
            ]);
        }

        DB::beginTransaction();

        try {
            // Check if member has enough points
            if ($member->total_points < $validated['points']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Poin Anda tidak cukup!',
                ]);
            }

            // Redeem points
            $description = "Tukar voucher: {$validated['voucher_name']}";
            $redeemed = $member->redeemPoints($validated['points'], $description);

            if (!$redeemed) {
                throw new \Exception('Gagal menukar poin');
            }

            // Create voucher
            $voucher = MemberVoucher::create([
                'member_id' => $member->id,
                'voucher_type' => $validated['voucher_id'],
                'voucher_name' => $validated['voucher_name'],
                'discount_type' => $validated['discount_type'],
                'discount_value' => $validated['discount_value'],
                'min_purchase' => $validated['min_purchase'],
                'points_used' => $validated['points'],
                'status' => 'active',
                'expired_at' => now()->addMonths(3), // Voucher berlaku 3 bulan
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menukar ' . $validated['points'] . ' poin! Voucher Anda: ' . $voucher->voucher_code,
                'remaining_points' => $member->fresh()->total_points,
                'voucher_code' => $voucher->voucher_code,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
}

