<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrandModel>
 */
class BrandModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word();

        return [
            'brand_id' => \App\Models\Brand::factory(),
            'name_en' => ucfirst($name),
            'name_ar' => 'موديل ' . ucfirst($name),
            'slug' => \Str::slug($name),
        ];
    }
}
