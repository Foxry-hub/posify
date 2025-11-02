<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirect to appropriate dashboard based on role
        switch ($user->role) {
            case 'admin':
                // Get today's date range
                $today = Carbon::today();
                
                // Calculate statistics
                $totalSalesToday = Transaction::whereDate('created_at', $today)->sum('total');
                $totalTransactionsToday = Transaction::whereDate('created_at', $today)->count();
                $totalProducts = Product::count();
                $totalUsers = User::count();
                
                // Get recent transactions (last 5)
                $recentTransactions = Transaction::with(['user', 'items.product'])
                    ->latest()
                    ->take(5)
                    ->get();
                
                return view('dashboard.admin', compact(
                    'totalSalesToday',
                    'totalTransactionsToday',
                    'totalProducts',
                    'totalUsers',
                    'recentTransactions'
                ));
            case 'kasir':
                return view('dashboard.kasir');
            case 'pelanggan':
                // Get customer statistics
                $totalSpent = Transaction::where('customer_id', $user->id)->sum('total');
                $totalTransactions = Transaction::where('customer_id', $user->id)->count();
                $recentTransactions = Transaction::where('customer_id', $user->id)
                    ->with(['items.product'])
                    ->latest()
                    ->take(5)
                    ->get();
                
                return view('dashboard.pelanggan', compact('totalSpent', 'totalTransactions', 'recentTransactions'));
            default:
                return redirect()->route('landing');
        }
    }
}
