<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberVoucher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Tampilkan form pendaftaran member baru
     */
    public function create()
    {
        return view('kasir.members.create');
    }

    /**
     * Daftarkan pelanggan baru sebagai member
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'address' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Buat akun user baru sebagai pelanggan
            $user = User::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? strtolower(str_replace(' ', '', $validated['name'])) . '@member.com',
                'password' => Hash::make($validated['phone']), // Default password = nomor HP
                'role' => 'pelanggan',
                'address' => $validated['address'],
                'is_active' => true,
            ]);

            // Buat member
            $member = Member::create([
                'user_id' => $user->id,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 
                "Member berhasil didaftarkan! Kode Member: {$member->member_code}. Password default: {$validated['phone']}"
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Cari member berdasarkan nomor HP (untuk scan di kasir)
     */
    public function search(Request $request)
    {
        $phone = $request->input('phone');

        $user = User::where('phone', $phone)
            ->where('role', 'pelanggan')
            ->with('member')
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor HP tidak terdaftar. Apakah ingin mendaftarkan sebagai member?',
            ]);
        }

        if (!$user->member) {
            return response()->json([
                'success' => false,
                'is_customer' => true,
                'message' => 'Pelanggan belum menjadi member. Apakah ingin mendaftarkan sebagai member?',
                'customer' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'member' => [
                'id' => $user->member->id,
                'member_code' => $user->member->member_code,
                'name' => $user->name,
                'phone' => $user->phone,
                'total_points' => $user->member->total_points,
                'customer_id' => $user->id,
            ],
        ]);
    }

    /**
     * Upgrade existing customer menjadi member
     */
    public function upgrade(Request $request, User $user)
    {
        if ($user->member) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan sudah terdaftar sebagai member!',
            ]);
        }

        $member = Member::create([
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Berhasil! {$user->name} sekarang menjadi member dengan kode {$member->member_code}",
            'member' => [
                'id' => $member->id,
                'member_code' => $member->member_code,
                'name' => $user->name,
                'phone' => $user->phone,
                'total_points' => $member->total_points,
                'customer_id' => $user->id,
            ],
        ]);
    }

    /**
     * Cari voucher member berdasarkan kode voucher
     */
    public function searchVoucher(Request $request)
    {
        $voucherCode = $request->input('voucher_code');

        $voucher = MemberVoucher::where('voucher_code', $voucherCode)
            ->where('status', 'active')
            ->where('expired_at', '>', now())
            ->with('member.user')
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak ditemukan atau sudah tidak aktif!',
            ]);
        }

        return response()->json([
            'success' => true,
            'voucher' => [
                'code' => $voucher->voucher_code,
                'name' => $voucher->voucher_name,
                'type' => $voucher->voucher_type,
                'discount_type' => $voucher->discount_type,
                'discount_value' => $voucher->discount_value,
                'min_purchase' => $voucher->min_purchase,
                'expired_at' => $voucher->expired_at->format('d M Y'),
                'member_name' => $voucher->member->user->name,
                'member_phone' => $voucher->member->user->phone,
                'customer_id' => $voucher->member->user_id,
            ],
        ]);
    }

    /**
     * Cari voucher member berdasarkan barcode
     */
    public function searchVoucherByBarcode(Request $request)
    {
        $barcode = $request->input('barcode');

        $voucher = MemberVoucher::where('barcode', $barcode)
            ->where('status', 'active')
            ->where('expired_at', '>', now())
            ->with('member.user')
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak ditemukan atau sudah tidak aktif!',
            ]);
        }

        return response()->json([
            'success' => true,
            'voucher' => [
                'code' => $voucher->voucher_code,
                'name' => $voucher->voucher_name,
                'type' => $voucher->voucher_type,
                'discount_type' => $voucher->discount_type,
                'discount_value' => $voucher->discount_value,
                'min_purchase' => $voucher->min_purchase,
                'expired_at' => $voucher->expired_at->format('d M Y'),
                'member_name' => $voucher->member->user->name,
                'member_phone' => $voucher->member->user->phone,
                'customer_id' => $voucher->member->user_id,
            ],
        ]);
    }
}

