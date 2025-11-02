<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Html5-QRCode Library for Barcode Scanner -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <style>
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        }
        .cart-item {
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .category-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Left Side - Products -->
        <div class="flex-1 flex flex-col overflow-hidden bg-white">
            <!-- Header -->
            <header class="bg-gradient-to-r from-primary to-blue-600 shadow-lg px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-3xl font-bold mb-1 flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Point of Sale
                        </h1>
                        <p class="text-blue-100 text-sm">Kasir: {{ Auth::user()->name }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('kasir.transactions.index') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-xl transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Riwayat
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-white text-primary hover:bg-gray-50 rounded-xl transition font-semibold shadow-lg">
                            Dashboard
                        </a>
                    </div>
                </div>
            </header>

            <!-- Search Bar -->
            <div class="bg-gradient-to-br from-gray-50 to-white px-6 py-4 border-b shadow-sm">
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="text" id="productSearch" placeholder="🔍 Scan barcode atau cari produk..." 
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-base shadow-sm"
                            autofocus disabled>
                        <svg class="w-6 h-6 text-gray-400 absolute left-4 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="button" id="scanCameraBtn" onclick="openProductBarcodeScanner()" disabled class="px-6 py-3.5 bg-blue-500 hover:bg-blue-600 text-white rounded-xl text-sm font-semibold transition shadow-md whitespace-nowrap disabled:bg-blue-300 disabled:cursor-not-allowed disabled:opacity-70">
                        📷 Scan Kamera
                    </button>
                </div>
                <!-- Barcode Result Indicator -->
                <div id="barcodeSearchResult" class="mt-2 hidden">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-2 flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-semibold text-green-800" id="barcodeResultText">Produk ditemukan!</span>
                        </div>
                        <button type="button" onclick="clearBarcodeSearch()" class="text-green-600 hover:text-green-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="bg-white px-6 py-4 border-b">
                <div class="flex space-x-3 overflow-x-auto pb-1">
                    <button onclick="filterCategory('all')" class="category-btn px-6 py-2.5 rounded-xl whitespace-nowrap transition-all font-medium shadow-sm active">
                        Semua
                    </button>
                    @foreach($categories as $category)
                        <button onclick="filterCategory('{{ $category->slug }}')" class="category-btn px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl whitespace-nowrap transition-all font-medium">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1 overflow-y-auto px-8 py-6 bg-gradient-to-br from-gray-50 to-white">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5" id="productsContainer">
                        @foreach($products as $product)
                            <div class="product-card bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden cursor-pointer hover:border-primary" 
                                data-category="{{ $product->category->slug ?? '' }}"
                                onclick='addToCart(@json($product))'>
                                <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden flex items-center justify-center p-4">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 text-sm mb-2 line-clamp-2 min-h-[2.5rem]">{{ $product->name }}</h3>
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-primary font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">Stok:</span>
                                        <span class="text-xs font-bold px-2 py-1 rounded-full {{ $product->stock > 10 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700') }}">
                                            {{ $product->stock }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Order Panel -->
        <div class="w-[450px] bg-white border-l-2 border-gray-200 flex flex-col shadow-2xl">
            <!-- STEP 1: Customer Information -->
            <div id="step1Panel" class="flex-1 flex flex-col h-full">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-5 shadow-lg flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">Informasi Pelanggan</h2>
                            <p class="text-blue-100 text-sm">Langkah 1 dari 2</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center">
                            <span class="text-2xl font-bold">1</span>
                        </div>
                    </div>
                </div>

                <!-- Form Content with Scroll -->
                <div class="flex-1 overflow-y-auto">
                    <div class="px-6 py-6 space-y-6">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                            <p class="text-sm text-blue-800">
                                <strong>📋 Instruksi:</strong> Scan member untuk mendapat poin, atau pilih pelanggan biasa.
                            </p>
                        </div>

                        <!-- Member Scan Section -->
                        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-xl p-5">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-base font-bold text-gray-800 flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Scan Member (Dapat Poin!)
                                </h3>
                                <a href="{{ route('kasir.members.create') }}" target="_blank" 
                                   class="text-xs px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                    + Daftar Member Baru
                                </a>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="relative">
                                    <input type="tel" 
                                           id="memberPhone" 
                                           placeholder="Masukkan nomor HP member (08xxx)"
                                           class="w-full pl-10 pr-4 py-2.5 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                           pattern="[0-9]{10,13}">
                                    <svg class="w-5 h-5 text-yellow-600 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                
                                <button type="button" 
                                        onclick="scanMember()"
                                        class="w-full px-4 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white rounded-lg font-semibold transition shadow-md">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Scan Member
                                </button>

                                <!-- Member Info Display -->
                                <div id="memberInfo" class="hidden bg-white border-2 border-green-400 rounded-lg p-3">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-600 mb-1">Member Ditemukan:</p>
                                            <p class="font-bold text-gray-800" id="memberName">-</p>
                                            <p class="text-sm text-gray-600" id="memberCode">-</p>
                                            <div class="mt-2 flex items-center space-x-4">
                                                <div class="text-xs">
                                                    <span class="text-gray-600">Poin Saat Ini:</span>
                                                    <span class="font-bold text-green-600" id="memberPoints">0</span>
                                                </div>
                                                <div class="text-xs">
                                                    <span class="text-gray-600">Poin Didapat:</span>
                                                    <span class="font-bold text-blue-600" id="pointsWillEarn">0</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" onclick="clearMember()" class="text-red-500 hover:text-red-700 ml-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Not Member Message -->
                                <div id="notMemberMsg" class="hidden bg-red-50 border border-red-300 rounded-lg p-3">
                                    <p class="text-sm text-red-700 mb-2" id="notMemberText">Nomor HP tidak terdaftar sebagai member.</p>
                                    <button type="button" 
                                            onclick="registerAsMember()"
                                            id="upgradeBtn"
                                            class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
                                        Daftarkan Sebagai Member
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Select Customer -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Pilih Pelanggan Terdaftar
                            </label>
                            <select id="selectCustomer" onchange="fillCustomerData()"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-base">
                                <option value="">-- Pelanggan Umum / Input Manual --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" 
                                        data-name="{{ $customer->name }}" 
                                        data-phone="{{ $customer->phone }}"
                                        data-email="{{ $customer->email }}">
                                        {{ $customer->name }} - {{ $customer->email }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Atau <a href="{{ route('kasir.customers.create') }}" target="_blank" class="text-primary hover:underline font-semibold">Daftarkan pelanggan baru</a></p>
                        </div>

                        <!-- Customer Name -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Nama Pelanggan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="customerName" value="Umum" 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-base">
                            <p class="text-xs text-gray-500 mt-1">Nama akan tercetak di struk</p>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                No. Telepon / Email (Opsional)
                            </label>
                            <input type="text" id="customerPhone" placeholder="08xxxxxxxxxx atau email"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-base">
                            <p class="text-xs text-gray-500 mt-1">Untuk keperluan follow-up</p>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" onclick="selectPaymentMethod('cash')" 
                                    class="payment-method-btn active px-4 py-5 border-2 border-primary bg-primary/10 rounded-xl hover:bg-primary/20 transition flex flex-col items-center justify-center space-y-2" 
                                    data-method="cash">
                                    <span class="text-3xl">💵</span>
                                    <span class="font-semibold text-sm">Tunai</span>
                                </button>
                                <button type="button" onclick="qrisComingSoon()" 
                                    class="payment-method-btn px-4 py-5 border-2 border-gray-400 bg-gray-100 rounded-xl cursor-not-allowed opacity-75 transition flex flex-col items-center justify-center space-y-2 relative" 
                                    data-method="qris" disabled>
                                    <div class="relative flex items-center justify-center w-12 h-12">
                                        <span class="text-3xl opacity-40">📱</span>
                                        <i class="fas fa-lock absolute text-3xl text-gray-600"></i>
                                    </div>
                                    <span class="font-semibold text-sm text-gray-600">QRIS</span>
                                    <span class="text-xs text-orange-600 font-bold">Coming Soon</span>
                                </button>
                            </div>
                            <input type="hidden" id="paymentMethod" value="cash">
                        </div>

                        <!-- Voucher Section -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-300 rounded-xl p-4">
                            <label class="block text-sm font-bold text-purple-700 mb-2">
                                <i class="fas fa-ticket-alt mr-1"></i> Gunakan Voucher Member (Opsional)
                            </label>
                            <div class="flex gap-2">
                                <input type="text" id="voucherCode" placeholder="Scan barcode atau ketik kode voucher"
                                    class="flex-1 px-4 py-3 border-2 border-purple-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition text-base uppercase">
                                <button type="button" onclick="openVoucherBarcodeScanner()"
                                    class="px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition font-semibold whitespace-nowrap">
                                    <i class="fas fa-camera mr-1"></i> Scan
                                </button>
                                <button type="button" onclick="scanVoucher()"
                                    class="px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition font-semibold">
                                    <i class="fas fa-search mr-1"></i> Cek
                                </button>
                            </div>
                            
                            <!-- Voucher Info (Hidden by default) -->
                            <div id="voucherInfo" class="hidden mt-3 bg-white border-2 border-purple-300 rounded-lg p-3">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h6 class="font-bold text-purple-700" id="voucherName">-</h6>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Diskon: <strong id="voucherDiscount">-</strong>
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Min. Belanja: <strong id="voucherMinPurchase">-</strong>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Pemilik: <span id="voucherOwner">-</span>
                                        </p>
                                    </div>
                                    <button type="button" onclick="clearVoucher()" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times-circle fa-lg"></i>
                                    </button>
                                </div>
                                <input type="hidden" id="voucherCodeHidden">
                                <input type="hidden" id="voucherCustomerId">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Next Button - Fixed at Bottom -->
                <div class="border-t-2 border-gray-200 px-6 py-4 bg-white shadow-lg flex-shrink-0">
                    <button onclick="goToStep2()" 
                        class="w-full px-6 py-4 bg-gradient-to-r from-primary to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center space-x-2">
                        <span>Lanjut ke Pemilihan Produk</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- STEP 2: Product Selection & Checkout -->
            <div id="step2Panel" class="flex-1 flex-col hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-5 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">Keranjang Belanja</h2>
                            <p class="text-green-100 text-sm">Langkah 2 dari 2 • <span id="cartItemCount">0 item</span></p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center">
                            <span class="text-2xl font-bold">2</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Info Summary -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b-2 border-blue-200">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex-1">
                            <p class="text-xs text-gray-600 font-semibold">Pelanggan:</p>
                            <p class="text-sm font-bold text-gray-900" id="customerNameDisplay">-</p>
                        </div>
                        <div class="flex-1 text-right">
                            <p class="text-xs text-gray-600 font-semibold">Pembayaran:</p>
                            <p class="text-sm font-bold text-gray-900" id="paymentMethodDisplay">-</p>
                        </div>
                    </div>
                    <button onclick="backToStep1()" class="text-xs text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Ubah Informasi
                    </button>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto px-5 py-4 space-y-3 bg-gray-50" id="cartItems" style="max-height: calc(100vh - 520px); min-height: 150px;">
                    <div class="text-center text-gray-400 py-8">
                        <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-sm font-medium">Keranjang masih kosong</p>
                        <p class="text-xs text-gray-400 mt-1">Pilih produk dari menu sebelah kiri</p>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="border-t-2 border-gray-200 px-6 py-5 space-y-4 bg-white">
                    <!-- Total Summary -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 font-medium">Subtotal</span>
                            <span id="subtotalText" class="font-bold text-gray-900">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold border-t-2 border-gray-300 pt-2">
                            <span class="text-gray-800">Total</span>
                            <span id="totalText" class="text-primary">Rp 0</span>
                        </div>
                    </div>

                    <!-- Payment Input (Cash) -->
                    <div id="cashPaymentSection">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Bayar</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">Rp</span>
                            <input type="number" id="paidAmount" value="0" min="0" 
                                class="w-full pl-12 pr-4 py-3 border-2 border-primary rounded-xl focus:ring-2 focus:ring-primary text-lg font-bold text-center" 
                                oninput="calculateChange()">
                        </div>
                    </div>

                    <!-- QRIS Payment Section (Hidden by default) -->
                    <div id="qrisPaymentSection" class="hidden">
                        <!-- Generate QR Section -->
                        <div id="qrGenerateSection">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-xl p-4 mb-3">
                                <p class="text-sm text-gray-700 mb-2">
                                    <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                                    <strong>Instruksi QRIS:</strong>
                                </p>
                                <ol class="text-sm text-gray-600 ml-5 list-decimal space-y-1">
                                    <li>Klik tombol "Generate QR Code"</li>
                                    <li>Tunjukkan QR ke pelanggan</li>
                                    <li>Pelanggan scan dengan GoPay/OVO/Dana/etc</li>
                                    <li>Tunggu & konfirmasi pembayaran berhasil</li>
                                </ol>
                            </div>
                            
                            <button type="button" onclick="generateQRIS()" 
                                class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition font-bold shadow-lg">
                                <i class="fas fa-qrcode mr-2"></i> Generate QR Code
                            </button>
                        </div>
                        
                        <!-- QR Display Section (Hidden until generated) -->
                        <div id="qrDisplaySection" class="hidden">
                            <div class="bg-white rounded-lg p-4 mb-3 text-center border-2 border-blue-300">
                                <p class="text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-mobile-alt mr-1"></i> Scan QR Code di bawah:
                                </p>
                                <div id="qrCodeContainer" class="flex justify-center mb-3"></div>
                                <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                                    <p class="text-xs text-gray-600 mb-1">Total Pembayaran:</p>
                                    <p class="text-2xl font-bold text-blue-700" id="qrAmountDisplay">Rp 0</p>
                                </div>
                            </div>
                            
                            <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-3 mb-3">
                                <p class="text-sm text-yellow-800 text-center font-semibold">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu pembayaran dari pelanggan...
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" onclick="confirmQRISPayment()" 
                                    class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold">
                                    <i class="fas fa-check mr-1"></i> Sudah Bayar
                                </button>
                                <button type="button" onclick="cancelQRIS()" 
                                    class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-semibold">
                                    <i class="fas fa-times mr-1"></i> Batal
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Change -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-700">Kembalian</span>
                            <span id="changeText" class="text-2xl font-bold text-green-600">Rp 0</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="clearCart()" class="px-4 py-3.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl font-bold transition shadow-lg hover:shadow-xl transform hover:scale-105">
                            🗑️ Batal
                        </button>
                        <button onclick="processPayment()" id="payButton" disabled 
                            class="px-4 py-3.5 bg-gradient-to-r from-primary to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-bold transition shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            💰 Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Camera Scanner Modal for Product Barcode -->
    <div id="productScannerModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">📷 Scan Barcode Produk</h3>
                <button 
                    type="button" 
                    onclick="closeProductBarcodeScanner()" 
                    class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Scanner Container -->
            <div class="p-6">
                <div id="productReader" class="rounded-lg overflow-hidden border-4 border-blue-200"></div>
                
                <!-- Result Display -->
                <div id="productScanResult" class="hidden mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-700 font-semibold">
                        ✅ Barcode terdeteksi: <span id="productResultText" class="font-mono"></span>
                    </p>
                </div>

                <!-- Tips -->
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-700 font-semibold mb-2">💡 Tips Scanning:</p>
                    <ul class="text-xs text-blue-600 space-y-1 list-disc list-inside">
                        <li>Letakkan barcode horizontal dalam kotak scan</li>
                        <li>Gunakan pencahayaan yang cukup terang</li>
                        <li>Jaga jarak 10-20cm dari kamera</li>
                        <li>Tahan stabil, tunggu beberapa detik</li>
                        <li>Produk akan otomatis masuk ke keranjang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Camera Scanner Modal for Voucher Barcode -->
    <div id="voucherScannerModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">📷 Scan Barcode Voucher</h3>
                <button 
                    type="button" 
                    onclick="closeVoucherBarcodeScanner()" 
                    class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Scanner Container -->
            <div class="p-6">
                <div id="voucherReader" class="rounded-lg overflow-hidden border-4 border-purple-200"></div>
                
                <!-- Result Display -->
                <div id="voucherScanResult" class="hidden mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-700 font-semibold">
                        ✅ Barcode voucher terdeteksi: <span id="voucherResultText" class="font-mono"></span>
                    </p>
                </div>

                <!-- Tips -->
                <div class="mt-4 bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <p class="text-sm text-purple-700 font-semibold mb-2">💡 Tips Scanning:</p>
                    <ul class="text-xs text-purple-600 space-y-1 list-disc list-inside">
                        <li>Minta pelanggan menunjukkan barcode voucher</li>
                        <li>Letakkan barcode horizontal dalam kotak scan</li>
                        <li>Gunakan pencahayaan yang cukup terang</li>
                        <li>Jaga jarak 10-20cm dari kamera</li>
                        <li>Voucher akan otomatis terverifikasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let subtotal = 0;
        let discount = 0;
        let total = 0;
        let currentStep = 1;
        let memberData = null; // Store member data
        let html5QrCodeProduct = null; // Camera scanner instance
        let isProcessingProduct = false; // Flag to prevent multiple scans

        // ===== CAMERA BARCODE SCANNER FOR PRODUCTS =====
        function openProductBarcodeScanner() {
            // Check if customer info is filled (step 2)
            if (currentStep !== 2) {
                alert('Silakan isi informasi pelanggan terlebih dahulu di Langkah 1!');
                return;
            }
            
            const modal = document.getElementById('productScannerModal');
            modal.classList.remove('hidden');
            
            // Reset processing flag
            isProcessingProduct = false;
            
            // Initialize scanner
            html5QrCodeProduct = new Html5Qrcode("productReader");
            
            // Configuration optimized for LINEAR BARCODES (garis-garis)
            const config = {
                fps: 10,
                qrbox: { width: 400, height: 200 },  // Wider box for horizontal barcodes
                aspectRatio: 2.0,  // Horizontal rectangle
                // Explicitly support LINEAR barcode formats
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.EAN_13,      // Most common product barcode
                    Html5QrcodeSupportedFormats.EAN_8,
                    Html5QrcodeSupportedFormats.UPC_A,
                    Html5QrcodeSupportedFormats.UPC_E,
                    Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.CODE_39,
                    Html5QrcodeSupportedFormats.CODE_93,
                    Html5QrcodeSupportedFormats.ITF,
                    Html5QrcodeSupportedFormats.CODABAR,
                    Html5QrcodeSupportedFormats.QR_CODE
                ],
                // Enhanced scanning for barcodes
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true
                },
                rememberLastUsedCamera: true,
                showTorchButtonIfSupported: true
            };
            
            html5QrCodeProduct.start(
                { facingMode: "environment" }, // Use back camera if available
                config,
                (decodedText, decodedResult) => {
                    // Prevent multiple processing
                    if (isProcessingProduct) {
                        return;
                    }
                    
                    isProcessingProduct = true;
                    
                    // Success callback - barcode detected
                    console.log(`Product barcode detected: ${decodedText}`, decodedResult);
                    
                    // Stop scanner immediately
                    closeProductBarcodeScanner();
                    
                    // Show result
                    document.getElementById('productResultText').textContent = decodedText;
                    document.getElementById('productScanResult').classList.remove('hidden');
                    
                    // Play success sound
                    const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBTGH0fPTgjMGHm7A7+OZSA0PVq3n77BdGAg+ltrzxnMpBSp+zO/bljsHEmK57OihUBELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+u');
                    audio.play().catch(e => console.log('Audio play failed'));
                    
                    // Search product by barcode and add to cart
                    searchProductByBarcode(decodedText);
                },
                (errorMessage) => {
                    // Error callback - ignore, just keep scanning
                }
            ).catch((err) => {
                console.error('Unable to start scanner:', err);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.');
                closeProductBarcodeScanner();
            });
        }
        
        function closeProductBarcodeScanner() {
            if (html5QrCodeProduct) {
                html5QrCodeProduct.stop().then(() => {
                    html5QrCodeProduct.clear();
                    html5QrCodeProduct = null;
                }).catch((err) => {
                    console.error('Error stopping scanner:', err);
                });
            }

            const modal = document.getElementById('productScannerModal');
            modal.classList.add('hidden');

            // Hide result
            const resultDiv = document.getElementById('productScanResult');
            resultDiv.classList.add('hidden');
        }

        // ===== CAMERA BARCODE SCANNER FOR VOUCHER =====
        let html5QrCodeVoucher = null; // Voucher scanner instance
        let isProcessingVoucher = false; // Flag to prevent multiple scans

        function openVoucherBarcodeScanner() {
            const modal = document.getElementById('voucherScannerModal');
            modal.classList.remove('hidden');
            
            // Reset processing flag
            isProcessingVoucher = false;
            
            // Initialize scanner
            html5QrCodeVoucher = new Html5Qrcode("voucherReader");
            
            // Configuration optimized for LINEAR BARCODES
            const config = {
                fps: 10,
                qrbox: { width: 400, height: 200 },
                aspectRatio: 2.0,
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.EAN_13,
                    Html5QrcodeSupportedFormats.EAN_8,
                    Html5QrcodeSupportedFormats.CODE_39,
                    Html5QrcodeSupportedFormats.CODE_93,
                    Html5QrcodeSupportedFormats.UPC_A,
                    Html5QrcodeSupportedFormats.UPC_E,
                    Html5QrcodeSupportedFormats.ITF,
                    Html5QrcodeSupportedFormats.CODABAR,
                    Html5QrcodeSupportedFormats.QR_CODE
                ],
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true
                },
                rememberLastUsedCamera: true,
                showTorchButtonIfSupported: true
            };
            
            html5QrCodeVoucher.start(
                { facingMode: "environment" },
                config,
                (decodedText, decodedResult) => {
                    // Prevent multiple processing
                    if (isProcessingVoucher) {
                        return;
                    }
                    
                    isProcessingVoucher = true;
                    
                    // Success callback - barcode detected
                    console.log(`Voucher barcode detected: ${decodedText}`, decodedResult);
                    
                    // Stop scanner immediately
                    closeVoucherBarcodeScanner();
                    
                    // Show result
                    document.getElementById('voucherResultText').textContent = decodedText;
                    document.getElementById('voucherScanResult').classList.remove('hidden');
                    
                    // Fill voucher code input
                    document.getElementById('voucherCode').value = decodedText;
                    
                    // Play success sound
                    const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBTGH0fPTgjMGHm7A7+OZSA0PVq3n77BdGAg+ltrzxnMpBSp+zO/bljsHEmK57OihUBELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+u');
                    audio.play().catch(e => console.log('Audio play failed'));
                    
                    // Search voucher by barcode
                    searchVoucherByBarcode(decodedText);
                },
                (errorMessage) => {
                    // Error callback - keep scanning
                }
            ).catch((err) => {
                console.error('Unable to start voucher scanner:', err);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.');
                closeVoucherBarcodeScanner();
            });
        }
        
        function closeVoucherBarcodeScanner() {
            if (html5QrCodeVoucher) {
                html5QrCodeVoucher.stop().then(() => {
                    html5QrCodeVoucher.clear();
                    html5QrCodeVoucher = null;
                }).catch((err) => {
                    console.error('Error stopping voucher scanner:', err);
                });
            }

            const modal = document.getElementById('voucherScannerModal');
            modal.classList.add('hidden');

            // Hide result
            const resultDiv = document.getElementById('voucherScanResult');
            resultDiv.classList.add('hidden');
        }

        // Search voucher by barcode
        async function searchVoucherByBarcode(barcode) {
            try {
                const response = await fetch(`{{ route('kasir.vouchers.searchByBarcode') }}?barcode=${barcode}`);
                const data = await response.json();

                if (data.success) {
                    const voucher = data.voucher;
                    
                    // Show voucher info
                    document.getElementById('voucherInfo').classList.remove('hidden');
                    document.getElementById('voucherName').textContent = voucher.name;
                    
                    // Format discount display
                    let discountText = '';
                    if (voucher.discount_type === 'percentage') {
                        discountText = voucher.discount_value + '%';
                    } else {
                        discountText = 'Rp ' + new Intl.NumberFormat('id-ID').format(voucher.discount_value);
                    }
                    document.getElementById('voucherDiscount').textContent = discountText;
                    
                    // Format min purchase
                    if (voucher.min_purchase > 0) {
                        document.getElementById('voucherMinPurchase').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(voucher.min_purchase);
                    } else {
                        document.getElementById('voucherMinPurchase').textContent = 'Tidak ada';
                    }
                    
                    document.getElementById('voucherOwner').textContent = voucher.member_name + ' (' + voucher.member_phone + ')';
                    
                    // IMPORTANT: Fill hidden fields for backend processing
                    document.getElementById('voucherCodeHidden').value = voucher.code;
                    document.getElementById('voucherCustomerId').value = voucher.customer_id;
                    
                    // Auto select customer if not selected
                    const currentCustomer = document.getElementById('selectCustomer').value;
                    if (!currentCustomer || currentCustomer != voucher.customer_id) {
                        alert('Voucher ini milik ' + voucher.member_name + '. Customer akan otomatis dipilih.');
                        document.getElementById('selectCustomer').value = voucher.customer_id;
                        fillCustomerData();
                    }
                    
                    alert('✅ Voucher berhasil ditemukan!\n\n' + voucher.name + '\nDiskon: ' + discountText);
                } else {
                    alert('❌ ' + data.message);
                    clearVoucher();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari voucher');
            }
        }

        // ===== MEMBER AND OTHER FUNCTIONS =====
        // Member Scan Function
        async function scanMember() {
            const phone = document.getElementById('memberPhone').value.trim();
            
            if (!phone) {
                alert('Masukkan nomor HP member!');
                return;
            }

            try {
                const response = await fetch(`{{ route('kasir.members.search') }}?phone=${phone}`);
                const data = await response.json();

                if (data.success) {
                    // Member found
                    memberData = data.member;
                    document.getElementById('memberInfo').classList.remove('hidden');
                    document.getElementById('notMemberMsg').classList.add('hidden');
                    document.getElementById('memberName').textContent = data.member.name;
                    document.getElementById('memberCode').textContent = `Kode: ${data.member.member_code}`;
                    document.getElementById('memberPoints').textContent = data.member.total_points;
                    
                    // Auto fill customer data
                    document.getElementById('selectCustomer').value = data.member.customer_id;
                    document.getElementById('customerName').value = data.member.name;
                    document.getElementById('customerPhone').value = data.member.phone;
                    
                    // Calculate points that will be earned
                    updatePointsWillEarn();
                    
                } else if (data.is_customer) {
                    // Customer exists but not member yet
                    document.getElementById('memberInfo').classList.add('hidden');
                    document.getElementById('notMemberMsg').classList.remove('hidden');
                    document.getElementById('notMemberText').textContent = `${data.customer.name} belum menjadi member.`;
                    document.getElementById('upgradeBtn').setAttribute('data-customer-id', data.customer.id);
                    document.getElementById('upgradeBtn').setAttribute('data-customer-name', data.customer.name);
                } else {
                    // Not found at all
                    document.getElementById('memberInfo').classList.add('hidden');
                    document.getElementById('notMemberMsg').classList.remove('hidden');
                    document.getElementById('notMemberText').textContent = 'Nomor HP tidak terdaftar. Silakan daftarkan sebagai member.';
                    document.getElementById('upgradeBtn').style.display = 'none';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari member');
            }
        }

        // Clear Member
        function clearMember() {
            memberData = null;
            document.getElementById('memberInfo').classList.add('hidden');
            document.getElementById('memberPhone').value = '';
            document.getElementById('pointsWillEarn').textContent = '0';
        }

        // Register as Member (upgrade existing customer)
        async function registerAsMember() {
            const customerId = document.getElementById('upgradeBtn').getAttribute('data-customer-id');
            const customerName = document.getElementById('upgradeBtn').getAttribute('data-customer-name');
            
            if (!customerId) {
                window.open('{{ route('kasir.members.create') }}', '_blank');
                return;
            }

            if (!confirm(`Daftarkan ${customerName} sebagai member?`)) {
                return;
            }

            try {
                const response = await fetch(`/kasir/members/${customerId}/upgrade`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    // Reload member data
                    memberData = data.member;
                    document.getElementById('memberInfo').classList.remove('hidden');
                    document.getElementById('notMemberMsg').classList.add('hidden');
                    document.getElementById('memberName').textContent = data.member.name;
                    document.getElementById('memberCode').textContent = `Kode: ${data.member.member_code}`;
                    document.getElementById('memberPoints').textContent = data.member.total_points;
                    document.getElementById('selectCustomer').value = data.member.customer_id;
                    updatePointsWillEarn();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mendaftarkan member');
            }
        }

        // Update points that will be earned based on total
        function updatePointsWillEarn() {
            if (memberData) {
                const points = Math.floor(total / 10000); // 1 point per 10k
                document.getElementById('pointsWillEarn').textContent = points;
            }
        }

        // Voucher Scan Function
        async function scanVoucher() {
            const voucherCode = document.getElementById('voucherCode').value.trim().toUpperCase();
            
            if (!voucherCode) {
                alert('Masukkan kode voucher!');
                return;
            }

            try {
                const response = await fetch(`{{ route('kasir.vouchers.search') }}?voucher_code=${voucherCode}`);
                const data = await response.json();

                if (data.success) {
                    const voucher = data.voucher;
                    
                    // Show voucher info
                    document.getElementById('voucherInfo').classList.remove('hidden');
                    document.getElementById('voucherName').textContent = voucher.name;
                    
                    // Format discount display
                    let discountText = '';
                    if (voucher.discount_type === 'percentage') {
                        discountText = voucher.discount_value + '%';
                    } else {
                        discountText = 'Rp ' + new Intl.NumberFormat('id-ID').format(voucher.discount_value);
                    }
                    document.getElementById('voucherDiscount').textContent = discountText;
                    
                    // Format min purchase
                    if (voucher.min_purchase > 0) {
                        document.getElementById('voucherMinPurchase').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(voucher.min_purchase);
                    } else {
                        document.getElementById('voucherMinPurchase').textContent = 'Tidak ada';
                    }
                    
                    document.getElementById('voucherOwner').textContent = voucher.member_name + ' (' + voucher.member_phone + ')';
                    document.getElementById('voucherCodeHidden').value = voucher.code;
                    document.getElementById('voucherCustomerId').value = voucher.customer_id;
                    
                    // Auto select customer if not selected
                    const currentCustomer = document.getElementById('selectCustomer').value;
                    if (!currentCustomer || currentCustomer != voucher.customer_id) {
                        alert('Voucher ini milik ' + voucher.member_name + '. Customer akan otomatis dipilih.');
                        document.getElementById('selectCustomer').value = voucher.customer_id;
                        fillCustomerData();
                    }
                    
                } else {
                    alert('❌ ' + data.message);
                    clearVoucher();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari voucher');
            }
        }

        // Clear Voucher
        function clearVoucher() {
            document.getElementById('voucherInfo').classList.add('hidden');
            document.getElementById('voucherCode').value = '';
            document.getElementById('voucherCodeHidden').value = '';
            document.getElementById('voucherCustomerId').value = '';
        }

        // Fill customer data when selecting from dropdown
        function fillCustomerData() {
            const select = document.getElementById('selectCustomer');
            const selectedOption = select.options[select.selectedIndex];
            
            if (select.value) {
                const name = selectedOption.getAttribute('data-name');
                const phone = selectedOption.getAttribute('data-phone');
                
                document.getElementById('customerName').value = name;
                document.getElementById('customerPhone').value = phone || '';
            } else {
                document.getElementById('customerName').value = 'Umum';
                document.getElementById('customerPhone').value = '';
            }
        }

        // Payment method selection
        function selectPaymentMethod(method) {
            document.querySelectorAll('.payment-method-btn').forEach(btn => {
                btn.classList.remove('active', 'border-primary', 'bg-primary/10');
                btn.classList.add('border-gray-300');
            });
            
            const selectedBtn = document.querySelector(`[data-method="${method}"]`);
            selectedBtn.classList.add('active', 'border-primary', 'bg-primary/10');
            selectedBtn.classList.remove('border-gray-300');
            
            document.getElementById('paymentMethod').value = method;
            
            // Don't show QRIS payment section in step 1
            // It will be shown in step 2
        }

        // QRIS Coming Soon notification
        function qrisComingSoon() {
            alert('🔒 Metode pembayaran QRIS sedang dalam pengembangan.\n\n📅 Coming Soon!\n\nSilakan gunakan metode pembayaran Tunai terlebih dahulu.');
        }

        // Go to step 2
        function goToStep2() {
            const customerName = document.getElementById('customerName').value.trim();
            
            if (!customerName) {
                alert('Nama pelanggan harus diisi!');
                return;
            }
            
            // Update display
            document.getElementById('customerNameDisplay').textContent = customerName;
            const paymentMethod = document.getElementById('paymentMethod').value;
            const paymentLabels = {
                'cash': '💵 Tunai',
                'qris': '📱 QRIS'
            };
            document.getElementById('paymentMethodDisplay').textContent = paymentLabels[paymentMethod];
            
            // Show appropriate payment section based on method
            if (paymentMethod === 'qris') {
                document.getElementById('cashPaymentSection').classList.add('hidden');
                document.getElementById('qrisPaymentSection').classList.remove('hidden');
            } else {
                document.getElementById('cashPaymentSection').classList.remove('hidden');
                document.getElementById('qrisPaymentSection').classList.add('hidden');
            }
            
            // Enable product search and scan camera button
            document.getElementById('productSearch').disabled = false;
            document.getElementById('scanCameraBtn').disabled = false;
            
            // Switch panels
            document.getElementById('step1Panel').classList.add('hidden');
            document.getElementById('step2Panel').classList.remove('hidden');
            document.getElementById('step2Panel').classList.add('flex');
            currentStep = 2;
        }

        // Back to step 1
        function backToStep1() {
            if (cart.length > 0) {
                if (!confirm('Keranjang akan dikosongkan jika kembali ke langkah 1. Lanjutkan?')) {
                    return;
                }
                cart = [];
            }
            
            // Reset QRIS section if active
            if (document.getElementById('paymentMethod').value === 'qris') {
                document.getElementById('qrDisplaySection').classList.add('hidden');
                document.getElementById('qrGenerateSection').classList.remove('hidden');
                document.getElementById('qrCodeContainer').innerHTML = '';
            }
            
            // Disable product search and scan camera button
            document.getElementById('productSearch').disabled = true;
            document.getElementById('scanCameraBtn').disabled = true;
            
            document.getElementById('step2Panel').classList.add('hidden');
            document.getElementById('step2Panel').classList.remove('flex');
            document.getElementById('step1Panel').classList.remove('hidden');
            currentStep = 1;
            renderCart();
        }

        function addToCart(product) {
            // Check if in step 2
            if (currentStep !== 2) {
                alert('⚠️ Silakan isi informasi pelanggan terlebih dahulu!');
                return;
            }
            
            const existingItem = cart.find(item => item.id === product.id);
            
            if (existingItem) {
                if (existingItem.quantity < product.stock) {
                    existingItem.quantity++;
                } else {
                    alert('Stok tidak mencukupi!');
                    return;
                }
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    stock: product.stock
                });
            }

            renderCart();
            calculateTotal();
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            renderCart();
            calculateTotal();
        }

        function updateQuantity(productId, newQuantity) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                if (newQuantity > item.stock) {
                    alert('Stok tidak mencukupi!');
                    return;
                }
                if (newQuantity <= 0) {
                    removeFromCart(productId);
                } else {
                    item.quantity = parseInt(newQuantity);
                }
                renderCart();
                calculateTotal();
            }
        }

        function renderCart() {
            const cartContainer = document.getElementById('cartItems');
            const cartItemCount = document.getElementById('cartItemCount');
            
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartItemCount.textContent = totalItems === 0 ? '0 item' : `${totalItems} item`;
            
            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <div class="text-center text-gray-400 py-8">
                        <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-sm font-medium">Keranjang masih kosong</p>
                        <p class="text-xs text-gray-400 mt-1">Pilih produk dari menu sebelah kiri</p>
                    </div>
                `;
                document.getElementById('payButton').disabled = true;
                return;
            }

            document.getElementById('payButton').disabled = false;
            
            let html = '';
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                html += `
                    <div class="cart-item bg-white rounded-xl p-3 shadow-sm border-2 border-gray-100 hover:border-primary transition">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1 pr-2">
                                <h4 class="font-bold text-sm text-gray-900 mb-1 leading-tight">${item.name}</h4>
                                <p class="text-xs text-gray-500">Rp ${item.price.toLocaleString('id-ID')} × ${item.quantity}</p>
                            </div>
                            <button onclick="removeFromCart(${item.id})" class="w-7 h-7 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1.5 bg-gray-50 rounded-lg p-1">
                                <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="w-7 h-7 bg-white hover:bg-red-500 hover:text-white text-gray-700 rounded-md flex items-center justify-center transition shadow-sm font-bold text-lg">−</button>
                                <input type="number" value="${item.quantity}" min="1" max="${item.stock}" 
                                    onchange="updateQuantity(${item.id}, this.value)"
                                    class="w-12 text-center border-0 bg-transparent font-bold text-gray-900 text-sm">
                                <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="w-7 h-7 bg-white hover:bg-green-500 hover:text-white text-gray-700 rounded-md flex items-center justify-center transition shadow-sm font-bold text-lg">+</button>
                            </div>
                            <p class="text-base font-bold text-primary">Rp ${itemTotal.toLocaleString('id-ID')}</p>
                        </div>
                    </div>
                `;
            });
            
            cartContainer.innerHTML = html;
        }

        function calculateTotal() {
            subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            discount = 0; // Diskon manual dihapus, hanya dari voucher
            total = subtotal - discount;

            document.getElementById('subtotalText').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('totalText').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            
            // Update points that will be earned for member
            updatePointsWillEarn();
            
            calculateChange();
        }

        function calculateChange() {
            const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
            const change = paidAmount - total;
            
            document.getElementById('changeText').textContent = `Rp ${Math.max(0, change).toLocaleString('id-ID')}`;
            document.getElementById('changeText').className = change >= 0 ? 'text-2xl font-bold text-green-600' : 'text-2xl font-bold text-red-600';
        }

        function clearCart() {
            if (cart.length === 0) {
                // If cart empty, go back to step 1
                backToStep1();
                return;
            }
            
            if (confirm('Yakin ingin mengosongkan keranjang?')) {
                cart = [];
                renderCart();
                calculateTotal();
                document.getElementById('paidAmount').value = '0';
                
                // Reset QRIS section if active
                if (document.getElementById('paymentMethod').value === 'qris') {
                    document.getElementById('qrDisplaySection').classList.add('hidden');
                    document.getElementById('qrGenerateSection').classList.remove('hidden');
                    document.getElementById('qrCodeContainer').innerHTML = '';
                }
            }
        }

        function processPayment() {
            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
            if (paidAmount < total) {
                alert('Jumlah pembayaran kurang dari total!');
                return;
            }

            const customerId = document.getElementById('selectCustomer').value;
            const voucherCode = document.getElementById('voucherCodeHidden').value || null;
            
            const formData = {
                customer_id: customerId || null,
                customer_name: document.getElementById('customerName').value || 'Umum',
                customer_phone: document.getElementById('customerPhone').value,
                voucher_code: voucherCode,
                payment_method: document.getElementById('paymentMethod').value,
                paid_amount: paidAmount,
                discount: discount,
                tax: 0,
                items: cart.map(item => ({
                    product_id: item.id,
                    quantity: item.quantity
                }))
            };

            // Submit form
            fetch('{{ route("kasir.transactions.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaksi berhasil!');
                    window.location.href = data.redirect;
                } else {
                    alert('Error: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses transaksi');
            });
        }

        // Category filter
        function filterCategory(category) {
            const buttons = document.querySelectorAll('.category-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            event.target.classList.add('active');

            const products = document.querySelectorAll('.product-card');
            products.forEach(product => {
                if (category === 'all' || product.dataset.category === category) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        // Product search
        document.getElementById('productSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const products = document.querySelectorAll('.product-card');
            
            // Check if search term looks like barcode (number only, length > 8)
            const isBarcode = /^\d{8,}$/.test(searchTerm);
            
            if (isBarcode && searchTerm.length >= 8) {
                // Search by barcode
                searchProductByBarcode(searchTerm);
            } else {
                // Normal search by name
                products.forEach(product => {
                    const productName = product.querySelector('h3').textContent.toLowerCase();
                    if (productName.includes(searchTerm)) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            }
        });

        // Focus barcode search input
        function focusBarcodeSearch() {
            console.log('focusBarcodeSearch() called');
            const searchInput = document.getElementById('productSearch');
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
                clearBarcodeSearch();
                console.log('Search input focused and cleared');
            } else {
                console.error('Search input not found');
            }
        }

        // Clear barcode search result
        function clearBarcodeSearch() {
            const resultDiv = document.getElementById('barcodeSearchResult');
            if (resultDiv) {
                resultDiv.classList.add('hidden');
            }
            const searchInput = document.getElementById('productSearch');
            if (searchInput) {
                searchInput.value = '';
            }
        }

        // Search product by barcode
        async function searchProductByBarcode(barcode) {
            try {
                const response = await fetch(`{{ route('kasir.products.searchByBarcode') }}?barcode=${barcode}`);
                const data = await response.json();

                if (data.success) {
                    const product = data.product;
                    
                    // Show success indicator
                    document.getElementById('barcodeSearchResult').classList.remove('hidden');
                    document.getElementById('barcodeResultText').textContent = `✅ ${product.name} (Rp ${product.price.toLocaleString('id-ID')})`;
                    
                    // Check if user is in step 2
                    if (currentStep !== 2) {
                        // Auto go to step 2 if needed
                        if (confirm(`Produk "${product.name}" ditemukan!\n\nLanjut ke pemilihan produk?`)) {
                            // Fill minimal customer data
                            if (!document.getElementById('customerName').value || document.getElementById('customerName').value === '') {
                                document.getElementById('customerName').value = 'Umum';
                            }
                            goToStep2();
                        }
                    }
                    
                    // Add to cart automatically
                    setTimeout(() => {
                        addToCart(product);
                        
                        // Play success sound (optional)
                        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBTGH0fPTgjMGHm7A7+OZSA0PVq3n77BdGAg+ltrzxnMpBSp+zO/bljsHEmK57OihUBELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+ujUhELTKXh8bllHAU2jdXzzn0vBSF1xe7hlEILElyx6+u');
                        audio.play().catch(e => console.log('Audio play failed:', e));
                        
                        // Clear search after 2 seconds
                        setTimeout(() => {
                            clearBarcodeSearch();
                        }, 2000);
                    }, 300);
                    
                } else {
                    // Product not found
                    document.getElementById('barcodeSearchResult').classList.remove('hidden');
                    document.getElementById('barcodeResultText').textContent = `❌ Barcode tidak ditemukan`;
                    document.getElementById('barcodeSearchResult').querySelector('.bg-green-50').className = 'bg-red-50 border border-red-200 rounded-lg p-2 flex items-center justify-between';
                    
                    setTimeout(() => {
                        clearBarcodeSearch();
                    }, 3000);
                }
            } catch (error) {
                console.error('Error searching barcode:', error);
                alert('Terjadi kesalahan saat mencari produk');
            }
        }

        // Quick pay buttons
        document.getElementById('totalText').addEventListener('click', function() {
            const quickPayAmounts = [10000, 20000, 50000, 100000];
            const rounded = Math.ceil(total / 1000) * 1000;
            document.getElementById('paidAmount').value = rounded;
            calculateChange();
        });

        // ========== QRIS PAYMENT FUNCTIONS ==========
        
        function generateQRIS() {
            if (total === 0) {
                alert('Total transaksi masih Rp 0. Silakan tambahkan produk terlebih dahulu.');
                return;
            }
            
            // Hide generate section, show display section
            document.getElementById('qrGenerateSection').classList.add('hidden');
            document.getElementById('qrDisplaySection').classList.remove('hidden');
            
            // Update amount display
            document.getElementById('qrAmountDisplay').textContent = 'Rp ' + formatRupiah(total);
            
            // Generate QR Code
            const qrContainer = document.getElementById('qrCodeContainer');
            qrContainer.innerHTML = ''; // Clear previous QR
            
            // Create QRIS data string
            // Format: MERCHANT_NAME|AMOUNT|TRANSACTION_ID
            const transactionId = 'TRX' + Date.now();
            const merchantName = 'VALSTORE POS';
            const qrisData = `${merchantName}|${total}|${transactionId}`;
            
            // Generate QR Code using QRCode.js
            new QRCode(qrContainer, {
                text: qrisData,
                width: 200,
                height: 200,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            
            // Auto-fill payment amount
            document.getElementById('paidAmount').value = total;
            calculateChange();
        }
        
        function confirmQRISPayment() {
            if (confirm('Apakah pelanggan sudah melakukan pembayaran via QRIS?')) {
                // Payment confirmed, ready to process transaction
                alert('✓ Pembayaran QRIS dikonfirmasi!');
                // Enable pay button
                document.getElementById('payButton').disabled = false;
            }
        }
        
        function cancelQRIS() {
            if (confirm('Batalkan pembayaran QRIS?')) {
                // Reset to generate section
                document.getElementById('qrDisplaySection').classList.add('hidden');
                document.getElementById('qrGenerateSection').classList.remove('hidden');
                
                // Clear QR code
                document.getElementById('qrCodeContainer').innerHTML = '';
                
                // Reset payment amount
                document.getElementById('paidAmount').value = 0;
                calculateChange();
            }
        }
        
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Kasir page loaded');
            
            // Add click event listener to scan button
            const scanButtons = document.querySelectorAll('button[onclick*="focusBarcodeSearch"]');
            console.log('Found scan buttons:', scanButtons.length);
            
            scanButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Scan button clicked via addEventListener');
                    focusBarcodeSearch();
                });
            });
        });
    </script>
    
    <!-- QRCode.js Library for QR Code Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</body>
</html>
