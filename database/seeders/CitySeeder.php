<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // UAE
        $uaeId = DB::table('countries')->where('code', 'AE')->value('id');
        DB::table('cities')->insert([
            ['country_id' => $uaeId, 'name_en' => 'Abu Dhabi', 'name_ar' => 'أبو ظبي', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => $uaeId, 'name_en' => 'Dubai', 'name_ar' => 'دبي', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => $uaeId, 'name_en' => 'Sharjah', 'name_ar' => 'الشارقة', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Saudi Arabia
        $ksaId = DB::table('countries')->where('code', 'SA')->value('id');
        DB::table('cities')->insert([
            ['country_id' => $ksaId, 'name_en' => 'Riyadh', 'name_ar' => 'الرياض', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => $ksaId, 'name_en' => 'Jeddah', 'name_ar' => 'جدة', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Jordan
        $joId = DB::table('countries')->where('code', 'JO')->value('id');
        DB::table('cities')->insert([
            ['country_id' => $joId, 'name_en' => 'Amman', 'name_ar' => 'عمان', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => $joId, 'name_en' => 'Irbid', 'name_ar' => 'إربد', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

}
