<?php

// Thêm CategorySeeder nếu chưa có
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate([
            'slug' => 'ao',
            'name' => 'Áo',
        ]);

        Category::firstOrCreate([
            'slug' => 'quan',
            'name' => 'Quần',
        ]);
    }
}