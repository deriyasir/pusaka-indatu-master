<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create();
        return [
            'name' => $faker->sentence(1),
            'slug' => $faker->slug,
            'weight' => $faker->numberBetween(80, 120),
            'pcs' => '1',
            'price' => $faker->numberBetween(50000, 100000),
            'stock' => $faker->numberBetween(5, 30),
            'description' => $faker->paragraph,
            'image' => $faker->image(storage_path('app/public/products'), 320, 320, false),
            'views' => 0,
        ];
    }
}
