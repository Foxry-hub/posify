<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\Member;
use App\Models\MemberVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display transaction history
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'items'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('kasir.transactions.index', compact('transactions'));
    }

    /**
     * Show POS interface for creating new transaction
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        $categories = \App\Models\Category::withCount('products')->get();
        $customers = \App\Models\User::where('role', 'pelanggan')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('kasir.transactions.create', compact('products', 'categories', 'customers'));
    }

    /**
     * Store a newly created transaction
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:users,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'voucher_code' => 'nullable|string',
            'payment_method' => 'required|in:cash,debit,credit,qris',
            'paid_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Calculate totals
            $subtotal = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock availability
                if ($product->stock < $item['quantity']) {
                    return back()->with('error', "Stok {$product->name} tidak mencukupi! Tersedia: {$product->stock}");
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $itemsData[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                ];
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;
            
            // Check and apply voucher if provided
            $voucher = null;
            $voucherDiscount = 0;
            if (!empty($validated['voucher_code'])) {
                $voucher = MemberVoucher::where('voucher_code', $validated['voucher_code'])
                    ->where('status', 'active')
                    ->where('expired_at', '>', now())
                    ->first();
                
                if ($voucher) {
                    // Check if customer is the voucher owner
                    if ($validated['customer_id'] && $voucher->member->user_id == $validated['customer_id']) {
                        // Check minimum purchase
                        if ($subtotal >= $voucher->min_purchase) {
                            $voucherDiscount = $voucher->calculateDiscount($subtotal);
                            $discount += $voucherDiscount;
                        } else {
                            $kurang = $voucher->min_purchase - $subtotal;
                            return response()->json([
                                'success' => false,
                                'message' => "Minimal belanja harus Rp " . number_format($voucher->min_purchase, 0, ',', '.') . " untuk menggunakan voucher ini. Tambahkan Rp " . number_format($kurang, 0, ',', '.') . " lagi.",
                            ], 400);
                        }
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Voucher ini hanya bisa digunakan oleh pemiliknya. Silakan pilih customer yang sesuai.',
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kode voucher tidak valid, sudah digunakan, atau sudah kadaluarsa.',
                    ], 400);
                }
            }
            
            $total = ($subtotal - $discount) + $tax;
            $paidAmount = $validated['paid_amount'];
            $change = $paidAmount - $total;

            // Validate payment
            if ($paidAmount < $total) {
                return back()->with('error', 'Jumlah pembayaran kurang dari total!');
            }

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'customer_id' => $validated['customer_id'] ?? null,
                'customer_name' => $validated['customer_name'] ?? 'Umum',
                'customer_phone' => $validated['customer_phone'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'paid_amount' => $paidAmount,
                'change' => $change,
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create transaction items and reduce stock
            foreach ($itemsData as $itemData) {
                $product = $itemData['product'];

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $itemData['quantity'],
                    'price' => $product->price,
                    'subtotal' => $itemData['subtotal'],
                ]);

                // Reduce stock
                $product->decrement('stock', $itemData['quantity']);
            }

            // Auto add poin untuk member
            $pointsEarned = 0;
            if ($transaction->customer_id) {
                $member = Member::where('user_id', $transaction->customer_id)->first();
                if ($member && $member->isActive()) {
                    $pointsEarned = $member->addPointsFromTransaction($transaction);
                }
            }

            // Mark voucher as used
            if ($voucher) {
                $voucher->use($transaction->id);
            }

            DB::commit();

            $message = 'Transaksi berhasil!';
            if ($voucherDiscount > 0) {
                $message .= " Diskon voucher: Rp " . number_format($voucherDiscount) . ".";
            }
            if ($pointsEarned > 0) {
                $message .= " Member mendapat {$pointsEarned} poin.";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('kasir.transactions.show', $transaction),
                'transaction_id' => $transaction->id,
                'points_earned' => $pointsEarned,
                'voucher_discount' => $voucherDiscount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified transaction
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'items.product']);
        
        return view('kasir.transactions.show', compact('transaction'));
    }

    /**
     * Print receipt
     */
    public function print(Transaction $transaction)
    {
        $transaction->load(['user', 'items']);
        
        return view('kasir.transactions.print', compact('transaction'));
    }

    /**
     * Get product by barcode or search
     */
    public function searchProduct(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('id', $query)
            ->where('stock', '>', 0)
            ->limit(10)
            ->get();

        return response()->json($products);
    }
}
