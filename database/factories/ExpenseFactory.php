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
            'user_id' => 1,
            'amount' => fake()->randomNumber(2, true) . '000',
            'category' => fake()->randomElement(['Groceries', 'Leisure', 'Electronics', 'Utilities', 'Clothing', 'Health', 'Others']),
            'description' => fake()->paragraph(),
            'date_time' => fake()->dateTimeBetween(startDate: '-24 week'),
            'payment_method' => 'Cash',
        ];
    }
}
