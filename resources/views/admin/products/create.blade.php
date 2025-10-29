<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - POSIFY Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-primary">POSIFY</h1>
                <p class="text-gray-400 text-sm">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Kelola Kategori
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-6 py-3 bg-primary bg-opacity-20 border-l-4 border-primary text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Kelola Barang
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Kelola Pengguna
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Laporan Penjualan
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-gray-300 hover:text-white transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="px-8 py-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                        <a href="{{ route('admin.products.index') }}" class="hover:text-primary">Kelola Barang</a>
                        <span>/</span>
                        <span class="text-gray-900 font-semibold">Tambah Produk</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h2>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8">
                <div class="max-w-3xl">
                    <div class="bg-white rounded-lg shadow p-6">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
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
                                        value="{{ old('name') }}"
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
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                    @if($categories->isEmpty())
                                        <p class="mt-1 text-sm text-orange-600">
                                            ⚠️ Belum ada kategori. <a href="{{ route('admin.categories.create') }}" class="underline">Buat kategori dulu</a>
                                        </p>
                                    @endif
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
                                        value="{{ old('price') }}"
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

                                <!-- Stock -->
                                <div class="md:col-span-2">
                                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Stock <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="number" 
                                        id="stock" 
                                        name="stock" 
                                        value="{{ old('stock', 0) }}"
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
                                    <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG, GIF (Max 2MB)</p>
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-4 hidden">
                                        <p class="text-sm font-semibold text-gray-700 mb-2">Preview:</p>
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
                                    >{{ old('description') }}</textarea>
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
                                    💾 Simpan Produk
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
