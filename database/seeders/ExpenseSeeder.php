<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        Expense::factory()
            ->count(10)
            ->for($user)
            ->create();
    }
}
