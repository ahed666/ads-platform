<?php

namespace Database\Factories;
use App\Models\Ad;
use App\Models\Company;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $name = $this->faker->words(3, true);

        return [
            'company_id' => 1, // 
            'category_id' => \App\Models\Category::factory(),
            'subcategory_id' => \App\Models\Subcategory::factory(),
            'brand_id' => \App\Models\Brand::factory(),
            'model_id' => \App\Models\BrandModel::factory(),

            'name_en' => ucfirst($name),
            'name_ar' => 'منتج ' . ucfirst($name),
            'slug' => \Str::slug($name),
            'description_en' => $this->faker->paragraph(),
            'description_ar' => 'وصف: ' . $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1000, 100000),
            'is_sold' => false,
        ];
    }
}
