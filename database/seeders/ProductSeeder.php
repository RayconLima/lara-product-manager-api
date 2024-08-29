<?php

namespace Database\Seeders;

use App\Models\{Category, Product};
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::first();
        Product::factory()->create(['category_id' => $category->id]);
    }
}
