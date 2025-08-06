<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->company();

        return [
            'category_id' => \App\Models\Category::factory(),
            'name_en' => $name,
            'name_ar' => 'شركة ' . $name,
            'slug' => \Str::slug($name),
            'logo' => $this->faker->imageUrl(200, 100, 'business', true, 'brand'),
        ];
    }
}
