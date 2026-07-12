<?php

namespace Database\Factories;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    protected $model = Entry::class;

    public function definition(): array
    {
        return [
            'supplier_id' => null,
            'entry_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'observation' => fake()->optional()->sentence(),
            'invoice_number' => fake()->optional()->numerify('NF-########'),
            'contract_number' => fake()->optional()->numerify('CT-####'),
            'batch_number' => fake()->optional()->numerify('LOTE-##'),
            'value' => fake()->randomFloat(2, 10, 50000),
            'entry_type' => $this->faker->randomElement(['purchased', 'feeding', 'reversal']),
        ];
    }

    public function purchased(): static
    {
        return $this->state(fn (array $attributes) => [
            'entry_type' => 'purchased',
        ]);
    }

    public function feeding(): static
    {
        return $this->state(fn (array $attributes) => [
            'entry_type' => 'feeding',
        ]);
    }

    public function reversal(): static
    {
        return $this->state(fn (array $attributes) => [
            'entry_type' => 'reversal',
        ]);
    }
}
