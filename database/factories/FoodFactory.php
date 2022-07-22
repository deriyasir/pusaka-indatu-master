<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
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
            'price' => $faker->numberBetween(10000, 50000),
            'satuan' => '1 porsi',
            'description' => $faker->paragraph,
            'image' => $faker->image(storage_path('app/public/foods'), 320, 320, false),
            'views' => 0,
        ];
    }
}
