<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
         'title' => fake()->text(25),
'description' => fake()->paragraph(1),
'image_path' => fake()->imageUrl(640, 480, 'banners', true),
'link' => fake()->url(),
'position' => fake()->numberBetween(1, 100),
'start_date' => fake()->dateTimeBetween('now', '+1 month'),
'end_date' => fake()->dateTimeBetween('+1 month', '+2 months'),
'is_active' => fake()->boolean(), 
        ];
    }
}
