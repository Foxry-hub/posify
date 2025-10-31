<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== CREATE TEST NON-MEMBER USER ===\n\n";

// Create a non-member pelanggan
$user = User::create([
    'name' => 'Pelanggan Non-Member',
    'email' => 'nonmember@test.com',
    'phone' => '08123456999',
    'password' => Hash::make('password123'),
    'role' => 'pelanggan',
    'address' => 'Jl. Test No. 123',
    'is_active' => true,
]);

echo "✅ User created successfully!\n\n";
echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Phone: {$user->phone}\n";
echo "Password: password123\n";
echo "Role: {$user->role}\n";
echo "Is Member: " . ($user->member ? 'YES' : 'NO') . "\n\n";

echo "=== LOGIN CREDENTIALS ===\n";
echo "URL: http://127.0.0.1:8000/login\n";
echo "Email: nonmember@test.com\n";
echo "Password: password123\n\n";

echo "ℹ️  User ini BELUM menjadi member.\n";
echo "   Dashboard akan menampilkan tombol Member dengan icon terkunci.\n";
