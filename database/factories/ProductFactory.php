<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        $category = Category::factory()->create(['name' => 'Bebidas']);
        return [
            'category_id'       => $category->id,
            'name'              => $this->faker->name(),
            'description'       => $this->faker->sentence(),
            'image'             => $this->faker->imageUrl(),
            'price'             => $this->faker->numberBetween(100, 9999),
            'expiration_date'   => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
