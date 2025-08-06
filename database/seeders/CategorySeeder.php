<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\AdType;
use App\Models\SubCategory;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carsType = AdType::where('name_en', 'Cars')->first();
        $equipmentType = AdType::where('name_en', 'Heavy Equipment')->first();

        $categories = [
            ['name_en' => 'Vehicles', 'name_ar' => 'مركبات', 'ad_type_id' => $carsType->id],
            ['name_en' => 'Construction Machines', 'name_ar' => 'آلات البناء', 'ad_type_id' => $equipmentType->id],
        ];

        foreach ($categories as $cat) {
            Category::create([
                ...$cat,
                'slug' => Str::slug($cat['name_en']),
            ]);
        }
    }
}
