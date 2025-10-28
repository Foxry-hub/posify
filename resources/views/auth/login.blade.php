<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POSIFY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Back -->
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center text-gray-600 hover:text-primary transition mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">POSIFY</h1>
            <p class="text-gray-600">Sistem Kasir Modern & Terpercaya</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h2>
            <p class="text-gray-600 mb-6">Silakan login untuk melanjutkan</p>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition @error('email') border-red-500 @enderror" 
                        placeholder="nama@email.com"
                        required
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition @error('password') border-red-500 @enderror" 
                        placeholder="Masukkan password"
                        required
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <span class="ml-2 text-gray-700 text-sm">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-sm text-primary hover:text-red-600 transition">Lupa Password?</a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-primary to-red-600 text-white py-3 rounded-xl font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    Login
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">atau</span>
                </div>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-primary font-semibold hover:text-red-600 transition">Daftar Sekarang</a>
                </p>
            </div>
        </div>

        <!-- Quick Login Demo -->
        <div class="mt-6 bg-white bg-opacity-50 backdrop-blur-sm rounded-2xl p-4">
            <p class="text-sm text-gray-600 text-center mb-3">Quick Login Demo:</p>
            <div class="grid grid-cols-3 gap-2 text-xs">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="admin@posify.id">
                    <input type="hidden" name="password" value="password">
                    <button type="submit" class="w-full bg-purple-500 text-white py-2 rounded-lg hover:bg-purple-600 transition">
                        Admin
                    </button>
                </form>
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="kasir@posify.id">
                    <input type="hidden" name="password" value="password">
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                        Kasir
                    </button>
                </form>
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="pelanggan@posify.id">
                    <input type="hidden" name="password" value="password">
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">
                        Pelanggan
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
