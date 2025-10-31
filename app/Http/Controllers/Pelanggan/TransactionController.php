<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display list of customer's own transactions
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'items.product'])
            ->where('customer_id', Auth::id())
            ->latest();

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan metode pembayaran
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $transactions = $query->paginate(15);

        // Hitung total statistics
        $totalSpent = Transaction::where('customer_id', Auth::id())->sum('total');
        $totalTransactions = Transaction::where('customer_id', Auth::id())->count();
        $totalItems = Transaction::where('customer_id', Auth::id())
            ->withCount('items')
            ->get()
            ->sum('items_count');

        return view('pelanggan.transactions.index', compact(
            'transactions', 
            'totalSpent', 
            'totalTransactions', 
            'totalItems'
        ));
    }

    /**
     * Display the specified transaction detail
     */
    public function show(Transaction $transaction)
    {
        // Pastikan pelanggan hanya bisa lihat transaksi mereka sendiri
        if ($transaction->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $transaction->load(['user', 'items.product']);

        return view('pelanggan.transactions.show', compact('transaction'));
    }
}
