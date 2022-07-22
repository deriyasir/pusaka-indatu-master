<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
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
            'title' => $faker->sentence,
            'slug' => $faker->slug,
            'headline' => $faker->sentence,
            'content' => $faker->paragraph,
            'category' => 'artikel',
            'product_id' => null,
            'image' => $faker->image(storage_path('app/public/blogs'), 640, 320, false),
            'author_id' => 1,
            'views' => 0,
        ];
    }
}
