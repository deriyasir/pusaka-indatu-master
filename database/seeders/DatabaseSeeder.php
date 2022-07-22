<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Food;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Yasir Anderi',
            'email' => 'deriyasir@gmail.com',
            'phone' => '081298989898',
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        if (!file_exists(storage_path('app/public/blogs'))) {
            mkdir(storage_path('app/public/blogs'), 0777, true);
        }

        if (!file_exists(storage_path('app/public/foods'))) {
            mkdir(storage_path('app/public/foods'), 0777, true);
        }

        if (!file_exists(storage_path('app/public/products'))) {
            mkdir(storage_path('app/public/products'), 0777, true);
        }

        Blog::factory()->count(10)->create();
        Product::factory()->count(10)->create();
        Food::factory()->count(10)->create();
    }
}
