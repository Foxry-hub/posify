<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Kasir\TransactionController;
use App\Http\Controllers\Kasir\CustomerController;
use App\Http\Controllers\Kasir\ReportController as KasirReportController;
use App\Http\Controllers\Kasir\MemberController;
use App\Http\Controllers\Pelanggan\TransactionController as PelangganTransactionController;
use App\Http\Controllers\Pelanggan\MemberController as PelangganMemberController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Requires Authentication)
Route::middleware(['auth', 'account.active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'account.active', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    
    // Transactions
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [AdminTransactionController::class, 'show'])->name('transactions.show');
    
    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [AdminReportController::class, 'print'])->name('reports.print');
});

// Kasir Routes
Route::middleware(['auth', 'account.active', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{transaction}/print', [TransactionController::class, 'print'])->name('transactions.print');
    Route::get('/products/search', [TransactionController::class, 'searchProduct'])->name('products.search');
    Route::get('/products/barcode', [TransactionController::class, 'searchByBarcode'])->name('products.searchByBarcode');
    
    // Customers
    Route::resource('customers', CustomerController::class);
    Route::get('/customers-search', [CustomerController::class, 'search'])->name('customers.search');
    
    // Members
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::get('/members/search', [MemberController::class, 'search'])->name('members.search');
    Route::post('/members/{user}/upgrade', [MemberController::class, 'upgrade'])->name('members.upgrade');
    Route::get('/vouchers/search', [MemberController::class, 'searchVoucher'])->name('vouchers.search');
    Route::get('/vouchers/barcode', [MemberController::class, 'searchVoucherByBarcode'])->name('vouchers.searchByBarcode');
    
    // Reports
    Route::get('/reports', [KasirReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [KasirReportController::class, 'print'])->name('reports.print');
});

// Pelanggan Routes
Route::middleware(['auth', 'account.active', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/transactions', [PelangganTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [PelangganTransactionController::class, 'show'])->name('transactions.show');
    
    // Member
    Route::get('/member', [PelangganMemberController::class, 'index'])->name('member.index');
    Route::get('/member/redeem', [PelangganMemberController::class, 'redeemPage'])->name('member.redeem');
    Route::post('/member/redeem', [PelangganMemberController::class, 'redeem'])->name('member.redeem.process');
});
