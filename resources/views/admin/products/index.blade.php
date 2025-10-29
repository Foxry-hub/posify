<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang - POSIFY Admin</title>
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
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Barang</h2>
                        <p class="text-sm text-gray-600">Manajemen produk/barang</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">Admin: {{ Auth::user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                        <p class="font-semibold">✓ Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                        <p class="font-semibold">✗ Error!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Action Bar -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="text-gray-600">Total: <span class="font-bold">{{ $products->total() }}</span> produk</p>
                    </div>
                    <a href="{{ route('admin.products.create') }}" class="bg-primary text-white px-6 py-2.5 rounded-lg hover:bg-red-600 transition font-semibold">
                        + Tambah Produk
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Gambar</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($products as $index => $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $products->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-2xl">
                                                    📦
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                            @if($product->description)
                                                <div class="text-sm text-gray-500">{{ Str::limit($product->description, 40) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-purple-100 text-purple-800 px-2.5 py-1 rounded-full text-xs font-semibold">
                                                {{ $product->category->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-3 py-1 rounded-full font-semibold {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $product->stock }} unit
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.products.edit', $product) }}" class="bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded hover:bg-yellow-200 transition font-semibold">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-1.5 rounded hover:bg-red-200 transition font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                            <div class="text-4xl mb-2">📦</div>
                                            <p class="font-semibold">Belum ada produk</p>
                                            <p class="text-sm">Klik tombol "Tambah Produk" untuk menambah produk baru</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
