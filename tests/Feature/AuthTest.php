<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A login feature test with correct credentials.
     */
    public function test_login_successfully(): void
    {
        $this->seed();

        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertOk()->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    /**
     * A test to verify the authenticated user details are returned successfully.
     */
    public function test_me_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/me');

        $response->assertOk()->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * A test to verify the user is logged out successfully.
     */
    public function test_logout_successfully(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->post('/api/logout');

        $response->assertOk()->assertJsonStructure(['message']);
    }

    /**
     * A test to verify the token is refreshed successfully.
     */
    public function test_refresh_successfully(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->post('/api/refresh');

        $response->assertOk()->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    /**
     * A login feature test with incorrect credentials.
     */
    public function test_login_unauthorized(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'drowssap',
        ]);

        $response->assertUnauthorized()->assertJsonStructure(['error']);
    }

    /**
     * A test to verify the user details are not returned when unauthenticated.
     */
    public function test_me_unauthenticated(): void
    {
        $response = $this->post('/api/me');

        $response->assertUnauthorized()->assertJsonStructure(['message']);
    }

    /**
     * A test to verify the user is not logged out when unauthenticated.
     */
    public function test_logout_unauthenticated(): void
    {
        $response = $this->post('/api/logout');

        $response->assertUnauthorized()->assertJsonStructure(['message']);
    }

    /**
     * A test to verify the token is not refreshed when unauthenticated.
     */
    public function test_refresh_unauthenticated(): void
    {
        $response = $this->post('/api/refresh');

        $response->assertUnauthorized()->assertJsonStructure(['message']);
    }
}
