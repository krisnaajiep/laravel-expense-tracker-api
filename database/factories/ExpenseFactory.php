<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 1, 1000),
            'category' => fake()->randomElement(['Groceries', 'Leisure', 'Electronics', 'Utilities', 'Clothing', 'Health', 'Others']),
            'description' => fake()->paragraph(),
            'date_time' => fake()->dateTimeBetween('3 months ago'),
        ];
    }
}
