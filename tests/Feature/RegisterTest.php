<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A register feature test successfully.
     */
    public function test_register_successfully(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertCreated()->assertJsonStructure([
            'message',
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    /**
     * A register feature test validation error.
     */
    public function test_register_validation_error(): void
    {
        $response = $this->post('/api/register', [
            'name' => '',
            'email' => 'testexample.com',
            'password' => '',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * A register feature test email already exists.
     */
    public function test_register_email_already_exists(): void
    {
        $this->seed();

        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors(['email']);
    }
}
