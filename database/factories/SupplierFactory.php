<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'legal_name' => fake()->company(),
            'trade_name' => fake()->companySuffix(),
            'cnpj' => fake()->numerify('##.###.###/####-##'),
            'state_registration' => fake()->numerify('###.###.###.###'),
            'municipal_registration' => fake()->numerify('########'),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'active' => true,
            'observation' => fake()->optional()->sentence(),
        ];
    }
}
