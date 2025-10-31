<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member Baru - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Daftar Member Baru</h1>
                    <p class="text-gray-600 mt-1">Daftarkan pelanggan sebagai member untuk mendapatkan poin</p>
                </div>
                <a href="{{ route('kasir.transactions.create') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke POS
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-blue-800 font-semibold mb-1">Keuntungan Menjadi Member:</h3>
                        <ul class="text-blue-700 text-sm space-y-1">
                            <li>✓ Dapatkan 1 poin setiap belanja Rp 10.000</li>
                            <li>✓ Tukar poin dengan diskon dan voucher</li>
                            <li>✓ Poin berlaku selama 1 tahun</li>
                            <li>✓ Login dengan nomor HP sebagai password</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Form Pendaftaran -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Data Pelanggan</h2>
                
                <form action="{{ route('kasir.members.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor HP -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor HP <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   required
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="08xxxxxxxxxx"
                                   pattern="[0-9]{10,13}">
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-info-circle"></i> Nomor HP akan digunakan sebagai password login
                            </p>
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email (Optional) -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="email@example.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                Alamat <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <textarea id="address" 
                                      name="address" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <a href="{{ route('kasir.transactions.create') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Sebagai Member
                        </button>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-lightbulb text-yellow-500 text-xl mr-3 mt-1"></i>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold mb-1">Catatan Penting:</p>
                        <ul class="space-y-1">
                            <li>• Member akan mendapat kode member otomatis</li>
                            <li>• Password default adalah nomor HP yang didaftarkan</li>
                            <li>• Member dapat login dan melihat riwayat transaksi</li>
                            <li>• Pastikan nomor HP belum terdaftar di sistem</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
