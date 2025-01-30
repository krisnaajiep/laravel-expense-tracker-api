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
            'date_time' => now()->toDateTimeString(),
        ]);

        $response->assertCreated()->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'amount',
                'category',
                'description',
                'date_time',
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
            'date_time' => 'invalid date time',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['amount', 'category', 'date_time']);
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
            'date_time' => now()->toDateTimeString(),
        ]);

        $response->assertUnauthorized()->assertJsonStructure(['message']);
    }

    /**
     * Test that all expenses can be retrieved successfully.
     */
    public function test_get_all_expenses_successfully(): void
    {
        $user = User::factory()->create();

        Expense::factory()->count(10)->for($user)->create();

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
                        'date_time',
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

    /**
     * Test that all expenses cannot be retrieved with unauthenticated user.
     */
    public function test_get_all_expenses_unauthenticated(): void
    {
        $response = $this->getJson('/api/expenses');

        $response->assertUnauthorized()->assertJsonStructure(['message']);
    }

    /**
     * Test that a single expense can be retrieved successfully.
     */
    public function test_update_expense_successfully(): void
    {
        $user = User::factory()->create();

        $expense = Expense::factory()->for($user)->create();

        $response = $this->actingAs($user)->putJson("/api/expenses/{$expense->id}", [
            'amount' => 200,
            'category' => 'Transport',
            'description' => 'Bus fare',
            'date_time' => now()->toDateTimeString(),
        ]);

        $response->assertOk()->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'user_id',
                'amount',
                'category',
                'description',
                'date_time',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test that an expense cannot be updated with validation errors.
     */
    public function test_update_expense_validation_error(): void
    {
        $user = User::factory()->create();

        $expense = Expense::factory()->for($user)->create();

        $response = $this->actingAs($user)->putJson("/api/expenses/{$expense->id}", [
            'amount' => 'invalid',
            'category' => '',
            'description' => '',
            'date_time' => 'invalid date time',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['amount', 'category', 'date_time']);
    }

    /**
     * Test that an expense cannot be updated with unauthenticated user.
     */
    public function test_update_expense_unauthenticated(): void
    {
        $user = User::factory()->create();

        $expense = Expense::factory()->for($user)->create();

        $response = $this->putJson("/api/expenses/{$expense->id}", [
            'amount' => 200,
            'category' => 'Transport',
            'description' => 'Bus fare',
            'date_time' => now()->toDateTimeString(),
        ]);

        $response->assertUnauthorized()->assertJsonStructure(['message']);
    }

    /**
     * Test that an expense cannot be updated by an unauthorized user.
     */
    public function test_update_expense_unauthorized(): void
    {
        $authorizedUser = User::factory()->create();
        $unauthorizedUser = User::factory()->create();

        $expense = Expense::factory()->for($authorizedUser)->create();

        $response = $this->actingAs($unauthorizedUser)->putJson("/api/expenses/{$expense->id}", [
            'amount' => 200,
            'category' => 'Transport',
            'description' => 'Bus fare',
            'date_time' => now()->toDateTimeString(),
        ]);

        $response->assertForbidden()->assertJsonStructure(['message']);
    }
}
