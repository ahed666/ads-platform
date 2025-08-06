<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategory>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'category_id' => \App\Models\Category::factory(),
            'name_en' => ucfirst($name),
            'name_ar' => 'فرعية ' . ucfirst($name),
            'slug' => \Str::slug($name),
        ];
    }
}
