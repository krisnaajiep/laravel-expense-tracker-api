<?php

namespace Tests\Feature;

use App\Models\Expense;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    protected array $expense = [
        'amount' => 55000,
        'category' => 'Electronics',
        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo eius alias molestias laborum cum consectetur, quasi ad id quis nam nisi non, delectus repudiandae quia fugiat esse impedit veniam reprehenderit!',
        'date_time' => '2024-10-05 22:29:00',
        'payment_method' => 'Cash',
    ];

    public function user_factory_create(): object
    {
        User::factory()->create();

        $user = User::latest()->first();

        return $user;
    }

    /**
     * A basic feature test example.
     */
    public function test_store_an_expense(): void
    {
        $user = $this->user_factory_create();

        $response = $this->actingAs($user)->post('/api/expenses', $this->expense);

        $response->assertStatus(201);
    }

    public function test_get_all_expenses(): void
    {
        $user = $this->user_factory_create();

        Expense::factory(5)->create();

        $response = $this->actingAs($user)->get('/api/expenses');

        $response->assertStatus(200);
    }

    public function test_get_an_expense(): void
    {
        $user = $this->user_factory_create();

        Expense::factory(1)->create();

        $response = $this->actingAs($user)->get('/api/expenses/1');

        $response->assertStatus(200);
    }

    public function test_update_an_expense(): void
    {
        $user = $this->user_factory_create();

        Expense::factory(1)->create();

        $response = $this->actingAs($user)->put('/api/expenses/1', $this->expense);

        $response->assertStatus(200);
    }

    public function test_delete_an_expense(): void
    {
        $user = $this->user_factory_create();

        Expense::factory(1)->create();

        $response = $this->actingAs($user)->delete('/api/expenses/1');

        $response->assertStatus(200);
    }
}
