# Dokumentasi Sidebar Admin POSIFY

## 📁 File Sidebar
Lokasi: `resources/views/layouts/partials/sidebar.blade.php`

## 🎯 Cara Menggunakan

### 1. Include Sidebar di Halaman Admin

Ganti seluruh kode sidebar (dari `<aside>` sampai `</aside>`) dengan:

```blade
@include('layouts.partials.sidebar')
```

### 2. Contoh Implementasi

**SEBELUM:**
```blade
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-800...">
            <div class="p-6">
                <h1>POSIFY</h1>
                ...
            </div>
            <nav>
                ...semua menu items...
            </nav>
            <div>...logout button...</div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            ...
        </main>
    </div>
</body>
```

**SESUDAH:**
```blade
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            ...
        </main>
    </div>
</body>
```

## ✨ Fitur Auto-Highlight

Sidebar menggunakan `@class` directive dan `request()->routeIs()` untuk otomatis highlight menu yang aktif:

```blade
<a href="{{ route('admin.categories.index') }}" 
   @class([
       'flex items-center px-6 py-3 transition',
       'bg-primary bg-opacity-20 border-l-4 border-primary text-white' => request()->routeIs('admin.categories.*'),
       'text-gray-300 hover:bg-gray-700 hover:text-white' => !request()->routeIs('admin.categories.*')
   ])>
```

### Cara Kerja:
- `request()->routeIs('admin.categories.*')` akan return `true` jika route saat ini adalah:
  - `admin.categories.index`
  - `admin.categories.create`
  - `admin.categories.edit`
  - Dan semua route lain yang dimulai dengan `admin.categories.`

- Wildcard `*` berarti semua sub-route dalam grup tersebut akan aktif

## 📋 Menu Items yang Tersedia

1. **Dashboard** → `dashboard`
2. **Kelola Kategori** → `admin.categories.*`
3. **Kelola Barang** → `admin.products.*`
4. **Kelola Pengguna** → `admin.users.*`
5. **Riwayat Transaksi** → `admin.transactions.*`
6. **Laporan Penjualan** → `admin.reports.*`

## 🎨 Styling

### Active Menu:
- Background: `bg-primary bg-opacity-20`
- Border: `border-l-4 border-primary`
- Text: `text-white`

### Inactive Menu:
- Text: `text-gray-300`
- Hover: `hover:bg-gray-700 hover:text-white`

## 🔧 Files yang Perlu Diupdate

Ganti sidebar di semua file berikut:

### ✅ Sudah Diupdate:
- [x] `resources/views/dashboard/admin.blade.php`

### 📝 Perlu Diupdate:
- [ ] `resources/views/admin/categories/index.blade.php`
- [ ] `resources/views/admin/categories/create.blade.php`
- [ ] `resources/views/admin/categories/edit.blade.php`
- [ ] `resources/views/admin/products/index.blade.php`
- [ ] `resources/views/admin/products/create.blade.php`
- [ ] `resources/views/admin/products/edit.blade.php`
- [ ] `resources/views/admin/users/index.blade.php`
- [ ] `resources/views/admin/users/create.blade.php`
- [ ] `resources/views/admin/users/edit.blade.php`

## 💡 Tips

1. **Konsistensi**: Gunakan `@include` di semua halaman admin untuk konsistensi
2. **Maintenance**: Update hanya 1 file (`sidebar.blade.php`) untuk mengubah semua sidebar
3. **Auto-Highlight**: Tidak perlu manual set active class, sudah otomatis
4. **Route Naming**: Pastikan route sudah diberi nama dengan pola yang benar
