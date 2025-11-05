<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white flex-shrink-0 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-30">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-primary">POSIFY</h1>
                <p class="text-gray-400 text-sm">
                    @if(auth()->user()->role === 'admin')
                        Admin Panel
                    @elseif(auth()->user()->role === 'kasir')
                        Kasir Panel
                    @else
                        User Panel
                    @endif
                </p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    
    <nav class="mt-6 flex-1 overflow-y-auto">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" 
           @class([
               'flex items-center px-6 py-3 transition',
               'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('dashboard'),
               'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('dashboard')
           ])>
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        @if(auth()->user()->role === 'admin')
            {{-- Admin Menu Items --}}
            {{-- Kelola Kategori --}}
            <a href="{{ route('admin.categories.index') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('admin.categories.*'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('admin.categories.*')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Kelola Kategori
            </a>

            {{-- Kelola Barang --}}
            <a href="{{ route('admin.products.index') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('admin.products.*'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('admin.products.*')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Kelola Barang
            </a>

            {{-- Kelola Pengguna --}}
            <a href="{{ route('admin.users.index') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('admin.users.*'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('admin.users.*')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Kelola Pengguna
            </a>

            {{-- Riwayat Transaksi --}}
            <a href="{{ route('admin.transactions.index') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('admin.transactions.*'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('admin.transactions.*')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Riwayat Transaksi
            </a>

            {{-- Laporan Penjualan --}}
            <a href="{{ route('admin.reports.index') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('admin.reports.*'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('admin.reports.*')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Laporan Penjualan
            </a>
        @elseif(auth()->user()->role === 'kasir')
            {{-- Kasir Menu Items --}}
            {{-- Transaksi Baru --}}
            <a href="{{ route('kasir.transactions.create') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('kasir.transactions.create'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('kasir.transactions.create')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Transaksi Baru
            </a>

            {{-- Riwayat Transaksi --}}
            <a href="{{ route('kasir.transactions.index') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('kasir.transactions.index') || request()->routeIs('kasir.transactions.show'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('kasir.transactions.index') && !request()->routeIs('kasir.transactions.show')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Riwayat Transaksi
            </a>

            {{-- Kelola Pelanggan --}}
            <a href="{{ route('kasir.customers.index') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('kasir.customers.*'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('kasir.customers.*')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Kelola Pelanggan
            </a>

            {{-- Laporan Penjualan --}}
            <a href="{{ route('kasir.reports.index') }}" 
               @class([
                   'flex items-center px-6 py-3 transition',
                   'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('kasir.reports.*'),
                   'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('kasir.reports.*')
               ])>
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Laporan Penjualan
            </a>
        @endif
    </nav>

    {{-- Logout Button --}}
    <div class="p-6 border-t border-gray-700">
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

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>