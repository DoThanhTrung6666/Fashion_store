<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

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
        return [
            'name' => fake()->text(10),
            'slug' => '',
            'description' => fake()->text(20),
            'logo' => '',
            'status' => rand(1, 0),
            'website_url' => '',
            'country' => fake()->text(20),
        ];
    }
}
