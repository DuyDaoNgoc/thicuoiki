<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy ID của danh mục "Áo" và "Quần"
        $aoCategory = Category::where('slug', 'ao')->first();
        $quanCategory = Category::where('slug', 'quan')->first();

        // Tạo sản phẩm cho danh mục Áo
        $aoProducts = [
            'Áo Thun Adidas',
            'Áo Sơ Mi Zara',
            'Áo Khoác North Face',
            'Áo Hoodie Nike',
            'Áo Polo Lacoste',
        ];

        foreach ($aoProducts as $name) {
            Product::create([
                'name' => $name,
                'description' => 'Mô tả chi tiết cho sản phẩm áo.',
                'price' => rand(100000, 500000),
                'image' => '', // Thêm link hình ảnh nếu có
                'stock' => rand(0, 20),
                'is_featured' => rand(0, 1),
                'slug' => Str::slug($name) . '-' . uniqid(),
                'category_id' => $aoCategory->id, // ID của danh mục Áo
            ]);
        }

        // Tạo sản phẩm cho danh mục Quần
        $quanProducts = [
            'Quần Jean Levi\'s',
            'Quần Short Adidas',
            'Quần Kaki Uniqlo',
            'Quần Jogger Nike',
            'Quần Chinos H&M',
        ];

        foreach ($quanProducts as $name) {
            Product::create([
                'name' => $name,
                'description' => 'Mô tả chi tiết cho sản phẩm quần.',
                'price' => rand(100000, 500000),
                'image' => '', // Thêm link hình ảnh nếu có
                'stock' => rand(0, 20),
                'is_featured' => rand(0, 1),
                'slug' => Str::slug($name) . '-' . uniqid(),
                'category_id' => $quanCategory->id, // ID của danh mục Quần
            ]);
        }
    }
}