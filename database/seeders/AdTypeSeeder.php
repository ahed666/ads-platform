<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdType;

class AdTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $types = [
            ['name_en' => 'Cars', 'name_ar' => 'سيارات'],
            ['name_en' => 'Heavy Equipment', 'name_ar' => 'معدات ثقيلة'],
            ['name_en' => 'Houses', 'name_ar' => 'بيوت'],
        ];

        foreach ($types as $type) {
            AdType::create($type);
        }
    }
}
