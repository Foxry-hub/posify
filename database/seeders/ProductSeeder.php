<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elektronik = Category::where('slug', 'elektronik')->first();
        $fashion = Category::where('slug', 'fashion')->first();
        $makanan = Category::where('slug', 'makanan-minuman')->first();

        $products = [
            // Elektronik
            ['name' => 'Mouse Wireless Logitech', 'category_id' => $elektronik->id, 'price' => 150000, 'stock' => 25, 'description' => 'Mouse wireless dengan teknologi terbaru'],
            ['name' => 'Keyboard Mechanical RGB', 'category_id' => $elektronik->id, 'price' => 450000, 'stock' => 15, 'description' => 'Keyboard gaming mechanical dengan lampu RGB'],
            ['name' => 'Webcam HD 1080p', 'category_id' => $elektronik->id, 'price' => 350000, 'stock' => 20, 'description' => 'Webcam HD untuk meeting online'],
            ['name' => 'Headset Gaming', 'category_id' => $elektronik->id, 'price' => 275000, 'stock' => 30, 'description' => 'Headset gaming dengan mic noise cancelling'],
            ['name' => 'USB Flash Drive 32GB', 'category_id' => $elektronik->id, 'price' => 65000, 'stock' => 50, 'description' => 'Flash drive USB 3.0 speed'],
            ['name' => 'Power Bank 10000mAh', 'category_id' => $elektronik->id, 'price' => 125000, 'stock' => 40, 'description' => 'Power bank fast charging'],
            ['name' => 'Kabel HDMI 2M', 'category_id' => $elektronik->id, 'price' => 45000, 'stock' => 35, 'description' => 'Kabel HDMI high quality'],
            
            // Fashion
            ['name' => 'Kaos Polos Premium', 'category_id' => $fashion->id, 'price' => 85000, 'stock' => 60, 'description' => 'Kaos cotton combed 30s'],
            ['name' => 'Celana Jeans Slim Fit', 'category_id' => $fashion->id, 'price' => 225000, 'stock' => 25, 'description' => 'Celana jeans premium quality'],
            ['name' => 'Jaket Hoodie', 'category_id' => $fashion->id, 'price' => 195000, 'stock' => 20, 'description' => 'Jaket hoodie fleece'],
            ['name' => 'Sepatu Sneakers', 'category_id' => $fashion->id, 'price' => 350000, 'stock' => 15, 'description' => 'Sepatu sneakers casual'],
            ['name' => 'Tas Ransel', 'category_id' => $fashion->id, 'price' => 175000, 'stock' => 30, 'description' => 'Tas ransel multifungsi'],
            ['name' => 'Topi Baseball', 'category_id' => $fashion->id, 'price' => 55000, 'stock' => 45, 'description' => 'Topi baseball premium'],
            
            // Makanan & Minuman
            ['name' => 'Kopi Arabica 100g', 'category_id' => $makanan->id, 'price' => 45000, 'stock' => 50, 'description' => 'Kopi arabica premium'],
            ['name' => 'Teh Hijau Organik', 'category_id' => $makanan->id, 'price' => 35000, 'stock' => 40, 'description' => 'Teh hijau organik kemasan 50g'],
            ['name' => 'Coklat Batangan', 'category_id' => $makanan->id, 'price' => 15000, 'stock' => 100, 'description' => 'Coklat premium dark chocolate'],
            ['name' => 'Keripik Kentang', 'category_id' => $makanan->id, 'price' => 12000, 'stock' => 80, 'description' => 'Keripik kentang rasa original'],
            ['name' => 'Mie Instan Premium', 'category_id' => $makanan->id, 'price' => 8000, 'stock' => 150, 'description' => 'Mie instan rasa soto'],
            ['name' => 'Minuman Isotonik', 'category_id' => $makanan->id, 'price' => 7000, 'stock' => 120, 'description' => 'Minuman isotonik 500ml'],
            ['name' => 'Air Mineral 600ml', 'category_id' => $makanan->id, 'price' => 4000, 'stock' => 200, 'description' => 'Air mineral kemasan'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
