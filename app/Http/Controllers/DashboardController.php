<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirect to appropriate dashboard based on role
        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin');
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
