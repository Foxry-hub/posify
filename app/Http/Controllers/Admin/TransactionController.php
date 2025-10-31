<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'customer', 'items']);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by kasir
        if ($request->filled('kasir_id')) {
            $query->where('user_id', $request->kasir_id);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search by transaction code or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_code', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(20);

        // Get kasir list for filter
        $kasirList = User::where('role', 'kasir')->get();
        
        // Get customer list for filter
        $customerList = User::where('role', 'pelanggan')->get();

        // Calculate summary
        $summary = [
            'total_transactions' => $query->count(),
            'total_revenue' => $query->sum('total'),
            'total_discount' => $query->sum('discount'),
        ];

        return view('admin.transactions.index', compact('transactions', 'kasirList', 'customerList', 'summary'));
    }

    /**
     * Display the specified transaction
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'customer', 'items.product']);
        
        return view('admin.transactions.show', compact('transaction'));
    }
}
