<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\AdType;
use Illuminate\Support\Str;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $carsType = AdType::where('name_en', 'Cars')->first();
        $equipmentType = AdType::where('name_en', 'Heavy Equipment')->first();

        Brand::create(['name_en' => 'Toyota', 'name_ar' => 'تويوتا', 'ad_type_id' => $carsType->id]);
        Brand::create(['name_en' => 'BMW', 'name_ar' => 'بي إم دبليو', 'ad_type_id' => $carsType->id]);
        Brand::create(['name_en' => 'Caterpillar', 'name_ar' => 'كاتربيلر', 'ad_type_id' => $equipmentType->id]);
    }
}
