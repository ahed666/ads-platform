<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $vehicleCategory = Category::where('name_en', 'Vehicles')->first();
        $equipmentCategory = Category::where('name_en', 'Construction Machines')->first();

        $vehicleSubs = ['Sedan', 'SUV', 'Pickup'];
        $equipmentSubs = ['Excavators', 'Bulldozers'];

        foreach ($vehicleSubs as $sub) {
            SubCategory::create([
                'name_en' => $sub,
                'name_ar' => 'ترجمة ' . $sub,
                'slug' => Str::slug($sub),
                'category_id' => $vehicleCategory->id,
            ]);
        }

        foreach ($equipmentSubs as $sub) {
            SubCategory::create([
                'name_en' => $sub,
                'name_ar' => 'ترجمة ' . $sub,
                'slug' => Str::slug($sub),
                'category_id' => $equipmentCategory->id,
            ]);
        }
    }
}
