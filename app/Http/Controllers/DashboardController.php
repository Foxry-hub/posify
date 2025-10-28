<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                return view('dashboard.pelanggan');
            default:
                return redirect()->route('landing');
        }
    }
}
