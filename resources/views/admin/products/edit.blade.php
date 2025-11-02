<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - POSIFY Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Html5-QRCode Library for Barcode Scanner -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="px-8 py-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                        <a href="{{ route('admin.products.index') }}" class="hover:text-primary">Kelola Barang</a>
                        <span>/</span>
                        <span class="text-gray-900 font-semibold">Edit Produk</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit Produk: {{ $product->name }}</h2>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8">
                <div class="max-w-3xl">
                    <div class="bg-white rounded-lg shadow p-6">
                        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama Produk -->
                                <div class="md:col-span-2">
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nama Produk <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name', $product->name) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror"
                                        placeholder="Contoh: iPhone 15 Pro Max"
                                        required
                                    >
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        id="category_id" 
                                        name="category_id" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('category_id') border-red-500 @enderror"
                                        required
                                    >
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Harga -->
                                <div>
                                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Harga (Rp) <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="number" 
                                        id="price" 
                                        name="price" 
                                        value="{{ old('price', $product->price) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('price') border-red-500 @enderror"
                                        placeholder="50000"
                                        min="0"
                                        step="0.01"
                                        required
                                    >
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Barcode Scanner -->
                                <div class="md:col-span-2">
                                    <label for="barcode" class="block text-sm font-semibold text-gray-700 mb-2">
                                        📷 Barcode Produk
                                    </label>
                                    <div class="flex gap-2">
                                        <input 
                                            type="text" 
                                            id="barcode" 
                                            name="barcode" 
                                            value="{{ old('barcode', $product->barcode) }}"
                                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('barcode') border-red-500 @enderror"
                                            placeholder="Scan barcode atau ketik manual"
                                        >
                                        <button 
                                            type="button" 
                                            onclick="openBarcodeScanner()"
                                            class="px-6 py-2.5 bg-blue-500 text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition shadow-md whitespace-nowrap"
                                        >
                                            📷 Scan Kamera
                                        </button>
                                    </div>
                                    @error('barcode')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        💡 Gunakan kamera untuk scan barcode atau ketik manual. Barcode harus unik!
                                    </p>
                                    @if($product->barcode)
                                        <div class="mt-2 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                            <p class="text-sm text-blue-700">
                                                📦 Barcode saat ini: <span class="font-mono font-bold">{{ $product->barcode }}</span>
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Camera Scanner Modal -->
                                <div id="scannerModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
                                    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden">
                                        <!-- Header -->
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 flex justify-between items-center">
                                            <h3 class="text-xl font-bold text-white">📷 Scan Barcode dengan Kamera</h3>
                                            <button 
                                                type="button" 
                                                onclick="closeBarcodeScanner()" 
                                                class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition"
                                            >
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Scanner Container -->
                                        <div class="p-6">
                                            <div id="reader" class="rounded-lg overflow-hidden border-4 border-blue-200"></div>
                                            
                                            <!-- Result Display -->
                                            <div id="scanResult" class="hidden mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                                                <p class="text-sm text-green-700 font-semibold">
                                                    ✅ Barcode terdeteksi: <span id="resultText" class="font-mono"></span>
                                                </p>
                                            </div>

                                            <!-- Tips -->
                                            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                                <p class="text-sm text-blue-700 font-semibold mb-2">💡 Tips Scanning:</p>
                                                <ul class="text-xs text-blue-600 space-y-1 list-disc list-inside">
                                                    <li>Pastikan barcode dalam kotak scan</li>
                                                    <li>Gunakan pencahayaan yang cukup</li>
                                                    <li>Jaga jarak yang tepat dari kamera</li>
                                                    <li>Barcode akan otomatis terdeteksi</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock -->
                                <div class="md:col-span-2">
                                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Stock <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="number" 
                                        id="stock" 
                                        name="stock" 
                                        value="{{ old('stock', $product->stock) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('stock') border-red-500 @enderror"
                                        placeholder="100"
                                        min="0"
                                        required
                                    >
                                    @error('stock')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gambar -->
                                <div class="md:col-span-2">
                                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Gambar Produk
                                    </label>
                                    
                                    <!-- Current Image -->
                                    @if($product->image)
                                        <div class="mb-3">
                                            <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-48 h-48 object-cover rounded-lg border">
                                        </div>
                                    @endif
                                    
                                    <input 
                                        type="file" 
                                        id="image" 
                                        name="image" 
                                        accept="image/*"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('image') border-red-500 @enderror"
                                        onchange="previewImage(event)"
                                    >
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG, GIF (Max 2MB). Kosongkan jika tidak ingin mengubah gambar.</p>
                                    
                                    <!-- New Image Preview -->
                                    <div id="imagePreview" class="mt-4 hidden">
                                        <p class="text-sm font-semibold text-gray-700 mb-2">Preview gambar baru:</p>
                                        <img id="preview" src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg border">
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Deskripsi Produk
                                    </label>
                                    <textarea 
                                        id="description" 
                                        name="description" 
                                        rows="4"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('description') border-red-500 @enderror"
                                        placeholder="Deskripsi produk (opsional)"
                                    >{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-3 mt-6">
                                <button 
                                    type="submit" 
                                    class="bg-primary text-white px-6 py-2.5 rounded-lg hover:bg-red-600 transition font-semibold"
                                >
                                    💾 Update Produk
                                </button>
                                <a 
                                    href="{{ route('admin.products.index') }}" 
                                    class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-300 transition font-semibold"
                                >
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Camera Scanner Variables
        let html5QrCode = null;

        // Open Camera Scanner
        function openBarcodeScanner() {
            const modal = document.getElementById('scannerModal');
            modal.classList.remove('hidden');

            // Initialize the scanner
            html5QrCode = new Html5Qrcode("reader");

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

            // Start scanning
            html5QrCode.start(
                { facingMode: "environment" }, // Use back camera if available
                config,
                (decodedText, decodedResult) => {
                    // Success callback - barcode detected
                    console.log(`Barcode detected: ${decodedText}`, decodedResult);
                    
                    // Fill the input field
                    document.getElementById('barcode').value = decodedText;
                    
                    // Show result
                    const resultDiv = document.getElementById('scanResult');
                    const resultText = document.getElementById('resultText');
                    resultText.textContent = decodedText;
                    resultDiv.classList.remove('hidden');

                    // Play success sound
                    const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBTGH0fPTgjMGHm7A7+OZSA0PWqvn77BdGAg+ltryxnYpBSuAzPDaizsIHGSz6+yiTxELTKXh8bllHAU2jdXyzn0vBSd9yfDdlUEKElyx6OyrWBQKQ5zd8sFuJAUuh9Dy1YU2Bhxqvu7mnEoODlmt5O+zYBoGPJPY8saxahcHK4DN8dqMOwccZLbr7KVRDQtLpuHxt2ccBTaM1PLPfzAFKHvH790');
                    audio.play().catch(e => console.log('Audio play failed'));

                    // Close scanner after 1 second
                    setTimeout(() => {
                        closeBarcodeScanner();
                    }, 1000);
                },
                (errorMessage) => {
                    // Error callback - ignore, keep scanning
                }
            ).catch((err) => {
                // Handle errors
                console.error('Error starting scanner:', err);
                alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
                closeBarcodeScanner();
            });
        }

        // Close Camera Scanner
        function closeBarcodeScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    html5QrCode = null;
                }).catch((err) => {
                    console.error('Error stopping scanner:', err);
                });
            }

            const modal = document.getElementById('scannerModal');
            modal.classList.add('hidden');

            // Hide result
            const resultDiv = document.getElementById('scanResult');
            resultDiv.classList.add('hidden');
        }

        // Barcode Scanner Focus (for manual input)
        function focusBarcode() {
            const barcodeInput = document.getElementById('barcode');
            barcodeInput.focus();
            barcodeInput.select();
        }

        // Image Preview
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
