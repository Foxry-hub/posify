<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Produk elektronik dan gadget terbaru',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Pakaian, sepatu, dan aksesoris fashion',
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Produk makanan dan minuman',
            ],
            [
                'name' => 'Rumah Tangga',
                'description' => 'Peralatan dan perlengkapan rumah tangga',
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'description' => 'Produk kesehatan dan kecantikan',
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Peralatan dan perlengkapan olahraga',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
