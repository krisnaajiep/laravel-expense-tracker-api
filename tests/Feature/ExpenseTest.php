<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a new expense can be added successfully.
     */
    public function test_add_new_expense_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/expenses', [
            'amount' => 100,
            'category' => 'Food',
            'description' => 'Lunch',
        ]);

        $response->assertCreated()->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'amount',
                'category',
                'description',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test that a new expense cannot be added with validation errors.
     */
    public function test_add_new_expense_validation_error(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/expenses', [
            'amount' => 'invalid',
            'category' => '',
            'description' => '',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['amount', 'category']);
    }

    /**
     * Test that a new expense cannot be added with unauthenticated user.
     */
    public function test_add_new_expense_unauthenticated(): void
    {
        $response = $this->postJson('/api/expenses', [
            'amount' => 100,
            'category' => 'Food',
            'description' => 'Lunch',
        ]);

        $response->assertUnauthorized()->assertJsonStructure(['message']);
    }

    /**
     * Test that all expenses can be retrieved successfully.
     */
    public function test_get_all_expenses_successfully(): void
    {
        $user = User::factory()->create();

        Expense::factory()->count(5)->for($user)->create();

        $response = $this->actingAs($user)->getJson('/api/expenses');

        $response->assertOk()->assertJsonStructure([
            'total_amount',
            'expenses' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'amount',
                        'category',
                        'description',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ],
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ]);
    }
}
