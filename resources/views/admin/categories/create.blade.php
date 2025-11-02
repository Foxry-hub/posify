<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - POSIFY Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                        <a href="{{ route('admin.categories.index') }}" class="hover:text-primary">Kelola Kategori</a>
                        <span>/</span>
                        <span class="text-gray-900 font-semibold">Tambah Kategori</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Kategori Baru</h2>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8">
                <div class="max-w-2xl">
                    <div class="bg-white rounded-lg shadow p-6">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            
                            <!-- Nama Kategori -->
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Kategori <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror"
                                    placeholder="Contoh: Elektronik"
                                    required
                                >
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Slug akan dibuat otomatis dari nama kategori</p>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    rows="4"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('description') border-red-500 @enderror"
                                    placeholder="Deskripsi kategori (opsional)"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-3">
                                <button 
                                    type="submit" 
                                    class="bg-primary text-white px-6 py-2.5 rounded-lg hover:bg-red-600 transition font-semibold"
                                >
                                    💾 Simpan Kategori
                                </button>
                                <a 
                                    href="{{ route('admin.categories.index') }}" 
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
</body>
</html>
