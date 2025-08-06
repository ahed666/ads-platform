<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $password = Str::random(8); 
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super_admin@motorbazaar.com',
            'password' => Hash::make($password),
        ]);
        info("Super Admin Password: {$password}");

         $this->call([
        AdTypeSeeder::class,
        CategorySeeder::class,
        SubCategorySeeder::class,
        BrandSeeder::class,
        BrandModelSeeder::class,
        CountrySeeder::class,
        CitySeeder::class,
        
        RolesAndPermissionsSeeder::class,
    ]);
    }
}
