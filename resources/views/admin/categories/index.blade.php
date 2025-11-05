<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - POSIFY Admin</title>
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
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Kategori</h2>
                        <p class="text-sm text-gray-600">Manajemen kategori produk</p>
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
                        <p class="text-gray-600">Total: <span class="font-bold text-gray-900">{{ $categories->total() }}</span> kategori</p>
                    </div>
                    <a href="{{ route('admin.categories.create') }}" class="bg-gradient-to-br from-primary to-red-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition font-semibold inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Kategori
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dibuat</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($categories as $index => $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $categories->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $category->name }}</div>
                                        @if($category->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <code class="bg-gray-100 px-2 py-1 rounded">{{ $category->slug }}</code>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">
                                            {{ $category->products_count }} produk
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $category->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:shadow-md transition font-semibold">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <div class="text-4xl mb-2">📁</div>
                                        <p class="font-semibold">Belum ada kategori</p>
                                        <p class="text-sm">Klik tombol "Tambah Kategori" untuk membuat kategori baru</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($categories->hasPages())
                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
