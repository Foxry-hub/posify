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
        @include('layouts.partials.sidebar')

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
            <div class="p-6 md:p-8 max-w-7xl mx-auto">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow">
                        <p class="font-semibold">✓ Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow">
                        <p class="font-semibold">✗ Error!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Action Bar -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">Total: <span class="font-bold text-gray-900">{{ $products->total() }}</span> produk</p>
                    </div>
                    <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition font-semibold inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Produk
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Gambar</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Barcode</th>
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
                                        <td class="px-6 py-4 text-sm">
                                            @if($product->barcode)
                                                <div class="bg-blue-50 border border-blue-200 rounded px-2 py-1 inline-block">
                                                    <span class="font-mono text-xs font-semibold text-blue-700">📷 {{ $product->barcode }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
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
                                                <a href="{{ route('admin.products.edit', $product) }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:shadow-md transition font-semibold">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-gradient-to-br from-red-500 to-red-600 text-white px-4 py-2 rounded-lg hover:shadow-md transition font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
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
