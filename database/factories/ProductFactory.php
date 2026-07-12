<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'code' => null,
            'description' => fake()->optional()->sentence(),
            'quantity' => fake()->numberBetween(0, 1000),
            'max_stock_level' => fake()->numberBetween(100, 5000),
            'meansurement_unit' => fake()->randomElement(['un', 'kg', 'l', 'm', 'cx', 'pc']),
            'observation' => fake()->optional()->sentence(),
            'is_active' => true,
            'category_id' => null,
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
