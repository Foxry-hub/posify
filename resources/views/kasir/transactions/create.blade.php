<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <div class="relative">
                    <input type="text" id="productSearch" placeholder="Cari produk atau scan barcode..." 
                        class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-base shadow-sm">
                    <svg class="w-6 h-6 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
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
                                <strong>📋 Instruksi:</strong> Pilih pelanggan terdaftar atau isi manual untuk pelanggan baru.
                            </p>
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
                                    class="payment-method-btn active px-4 py-5 border-2 border-primary bg-primary/10 rounded-xl hover:bg-primary/20 transition flex flex-col items-center space-y-2" 
                                    data-method="cash">
                                    <span class="text-3xl">💵</span>
                                    <span class="font-semibold text-sm">Tunai</span>
                                </button>
                                <button type="button" onclick="selectPaymentMethod('debit')" 
                                    class="payment-method-btn px-4 py-5 border-2 border-gray-300 rounded-xl hover:border-primary hover:bg-primary/10 transition flex flex-col items-center space-y-2" 
                                    data-method="debit">
                                    <span class="text-3xl">💳</span>
                                    <span class="font-semibold text-sm">Debit</span>
                                </button>
                                <button type="button" onclick="selectPaymentMethod('credit')" 
                                    class="payment-method-btn px-4 py-5 border-2 border-gray-300 rounded-xl hover:border-primary hover:bg-primary/10 transition flex flex-col items-center space-y-2" 
                                    data-method="credit">
                                    <span class="text-3xl">💳</span>
                                    <span class="font-semibold text-sm">Credit</span>
                                </button>
                                <button type="button" onclick="selectPaymentMethod('qris')" 
                                    class="payment-method-btn px-4 py-5 border-2 border-gray-300 rounded-xl hover:border-primary hover:bg-primary/10 transition flex flex-col items-center space-y-2" 
                                    data-method="qris">
                                    <span class="text-3xl">📱</span>
                                    <span class="font-semibold text-sm">QRIS</span>
                                </button>
                            </div>
                            <input type="hidden" id="paymentMethod" value="cash">
                        </div>

                        <!-- Discount -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Diskon (Opsional)
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">Rp</span>
                                <input type="number" id="discount" value="0" min="0" 
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-base font-semibold">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada diskon</p>
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
                        <div class="flex justify-between text-sm" id="discountRow" style="display: none;">
                            <span class="text-gray-600 font-medium">Diskon</span>
                            <span id="discountText" class="font-bold text-red-600">- Rp 0</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold border-t-2 border-gray-300 pt-2">
                            <span class="text-gray-800">Total</span>
                            <span id="totalText" class="text-primary">Rp 0</span>
                        </div>
                    </div>

                    <!-- Payment Input -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Bayar</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">Rp</span>
                            <input type="number" id="paidAmount" value="0" min="0" 
                                class="w-full pl-12 pr-4 py-3 border-2 border-primary rounded-xl focus:ring-2 focus:ring-primary text-lg font-bold text-center" 
                                oninput="calculateChange()">
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

    <script>
        let cart = [];
        let subtotal = 0;
        let discount = 0;
        let total = 0;
        let currentStep = 1;

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
                'debit': '💳 Debit Card',
                'credit': '💳 Credit Card',
                'qris': '📱 QRIS'
            };
            document.getElementById('paymentMethodDisplay').textContent = paymentLabels[paymentMethod];
            
            // Show discount if exists
            const discountValue = parseFloat(document.getElementById('discount').value) || 0;
            if (discountValue > 0) {
                document.getElementById('discountRow').style.display = 'flex';
            }
            
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
            discount = parseFloat(document.getElementById('discount').value) || 0;
            total = subtotal - discount;

            document.getElementById('subtotalText').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('discountText').textContent = `- Rp ${discount.toLocaleString('id-ID')}`;
            document.getElementById('totalText').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            
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

            const formData = {
                customer_name: document.getElementById('customerName').value || 'Umum',
                customer_phone: document.getElementById('customerPhone').value,
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
            const searchTerm = e.target.value.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            
            products.forEach(product => {
                const productName = product.querySelector('h3').textContent.toLowerCase();
                if (productName.includes(searchTerm)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        // Quick pay buttons
        document.getElementById('totalText').addEventListener('click', function() {
            const quickPayAmounts = [10000, 20000, 50000, 100000];
            const rounded = Math.ceil(total / 1000) * 1000;
            document.getElementById('paidAmount').value = rounded;
            calculateChange();
        });
    </script>
</body>
</html>
