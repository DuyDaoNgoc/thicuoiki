<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advertisement; // ✅ Import model

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Advertisement::create([
            'title' => 'Giảm giá mùa hè',
            'image_path' => 'images/ads/ads.jpg',
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-30',
            'event_type' => 'summer_sale',
        ]);
        Advertisement::create([
            'title' => 'Giảm giá mùa hè',
            'image_path' => 'images/ads/adsd.png',
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-30',
            'event_type' => 'summer_sale',
        ]);
        Advertisement::create([
            'title' => 'Giảm giá mùa hè',
            'image_path' => 'images/ads/adss.png',
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-30',
            'event_type' => 'summer_sale',
        ]);
    }
}