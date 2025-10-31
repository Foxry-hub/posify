<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display sales report
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Main query for transactions
        $query = Transaction::with(['user', 'customer'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->whereHas('items', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        // Filter by kasir
        if ($request->filled('kasir_id')) {
            $query->where('user_id', $request->kasir_id);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $transactions = $query->latest()->paginate(20);

        // Summary statistics
        $summary = [
            'total_transactions' => $query->count(),
            'total_revenue' => $query->sum('total'),
            'total_discount' => $query->sum('discount'),
            'average_transaction' => $query->count() > 0 ? $query->sum('total') / $query->count() : 0,
        ];

        // Payment method breakdown
        $paymentBreakdownQuery = Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        
        if ($request->filled('customer_id')) {
            $paymentBreakdownQuery->where('customer_id', $request->customer_id);
        }
        if ($request->filled('product_id')) {
            $paymentBreakdownQuery->whereHas('items', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }
        if ($request->filled('kasir_id')) {
            $paymentBreakdownQuery->where('user_id', $request->kasir_id);
        }
        
        $paymentBreakdown = $paymentBreakdownQuery
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
            ->get();

        // Top products
        $topProductsQuery = TransactionItem::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        
        if ($request->filled('product_id')) {
            $topProductsQuery->where('product_id', $request->product_id);
        }
        
        $topProducts = $topProductsQuery
            ->select('product_id', 'product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        // Daily sales trend
        $dailySalesQuery = Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        
        if ($request->filled('customer_id')) {
            $dailySalesQuery->where('customer_id', $request->customer_id);
        }
        if ($request->filled('product_id')) {
            $dailySalesQuery->whereHas('items', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }
        if ($request->filled('kasir_id')) {
            $dailySalesQuery->where('user_id', $request->kasir_id);
        }
        
        $dailySales = $dailySalesQuery
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get filter options
        $customers = User::where('role', 'pelanggan')->orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $kasirList = User::where('role', 'kasir')->orderBy('name')->get();

        return view('admin.reports.index', compact(
            'transactions',
            'summary',
            'paymentBreakdown',
            'topProducts',
            'dailySales',
            'customers',
            'products',
            'kasirList',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Print report
     */
    public function print(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $query = Transaction::with(['user', 'customer', 'items'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Apply same filters
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->filled('product_id')) {
            $query->whereHas('items', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }
        if ($request->filled('kasir_id')) {
            $query->where('user_id', $request->kasir_id);
        }

        $transactions = $query->latest()->get();

        $summary = [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->sum('total'),
            'total_discount' => $transactions->sum('discount'),
        ];

        return view('admin.reports.print', compact('transactions', 'summary', 'startDate', 'endDate'));
    }
}
