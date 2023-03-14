<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filling>
 */
class FillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
            'image' => fake()->imageUrl(),
            'description' => fake()->realText(140),
            'unit_price' => 650,
            'min_quantity' => 5,
            'min_weight' => 2.5,
            'category_id' => fake()->numberBetween(1, 5)
        ];
    }
}