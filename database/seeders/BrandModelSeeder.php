<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\BrandModel;
use Illuminate\Support\Str;
class BrandModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $toyota = Brand::where('name_en', 'Toyota')->first();
        $caterpillar = Brand::where('name_en', 'Caterpillar')->first();

        BrandModel::create(['name_en' => 'Corolla', 'name_ar' => 'كورولا', 'brand_id' => $toyota->id]);
        BrandModel::create(['name_en' => 'CAT 320', 'name_ar' => 'كات ٣٢٠', 'brand_id' => $caterpillar->id]);
    }
}
