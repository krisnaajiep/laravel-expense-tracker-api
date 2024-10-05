<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected array $user = [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'verification_url' => 'http://expense-tracker-api.test/auth/email/verify',
    ];

    public function user_factory_create(): object
    {
        User::factory()->create();

        $user = User::latest()->first();

        return $user;
    }

    public function user_login(object $user)
    {
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return $response;
    }

    public function password_reset_link(object $user)
    {
        $response = $this->actingAs($user)->post('/api/auth/forgot-password', [
            'email' => $user->email,
            'reset_url' => 'http://expense-tracker-api.test/auth/reset-password',
        ]);

        return $response;
    }

    /**
     * A basic feature test example.
     */
    public function test_register(): void
    {
        $response = $this->postJson('/api/auth/register', $this->user);

        $response
            ->assertStatus(201)
            ->assertJson([
                'access_token' => $response->json('access_token'),
            ]);
    }

    public function test_verification_notification(): void
    {
        $this->postJson('/api/auth/register', $this->user);

        $user = User::latest()->first();

        $response = $this->actingAs($user)->post('/api/auth/email/verification-notification', [
            'verification_url' => 'http://expense-tracker-api.test/auth/email/verify',
        ]);

        $response->assertStatus(200);
    }

    public function test_verify_email(): void
    {
        Notification::fake();

        $this->postJson('/api/auth/register', $this->user);

        $user = User::latest()->first();

        Notification::assertSentTo($user, VerifyEmail::class, function ($notification) use ($user, &$verification_url) {
            $verification_url = $notification->toMail($user)->actionUrl;
            return !empty($verification_url);
        });

        $verification_url = explode('verify', $verification_url)[1];

        $response = $this->actingAs($user)->get('/api/auth/email/verify' . $verification_url);

        $response->assertStatus(200);
    }

    public function test_login(): void
    {
        $user = $this->user_factory_create();

        $response = $this->user_login($user);

        $response
            ->assertStatus(200)
            ->assertJson([
                'access_token' => $response->json('access_token'),
            ]);
    }

    public function test_me(): void
    {
        $user = $this->user_factory_create();

        $response = $this->actingAs($user)->get('/api/auth/me');

        $response->assertStatus(200);
    }

    public function test_refresh_token(): void
    {
        $user = $this->user_factory_create();

        $response = $this->user_login($user);

        $response = $this->actingAs($user)
            ->withHeader('Authorization', 'Bearier ' . $response->json('access_token'))
            ->post('/api/auth/refresh');

        $response
            ->assertStatus(200)
            ->assertJson([
                'access_token' => $response->json('access_token'),
            ]);
    }

    public function test_update_password(): void
    {
        $user = $this->user_factory_create();

        $this->user_login($user);

        $response = $this->actingAs($user)
            ->put('/api/auth/update-password', [
                'current_password' => 'password',
                'password' => 'changedpassword',
                'password_confirmation' => 'changedpassword',
            ]);

        $response->assertStatus(200);
    }

    public function test_logout(): void
    {
        $user = $this->user_factory_create();

        $this->user_login($user);

        $response = $this->actingAs($user)->post('/api/auth/logout');

        $response->assertStatus(200);
    }

    public function test_password_reset_link(): void
    {
        $user = $this->user_factory_create();

        $response = $this->password_reset_link($user);

        $response->assertStatus(200);
    }

    public function test_new_password(): void
    {
        Notification::fake();

        $user = $this->user_factory_create();

        $this->password_reset_link($user);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user, &$reset_url) {
            $reset_url = $notification->toMail($user)->actionUrl;
            return !empty($reset_url);
        });

        $reset_token = explode('reset-password/', $reset_url)[1];

        $response = $this->post('api/auth/reset-password', [
            'token' => $reset_token,
            'email' => $user->email,
            'password' => 'changedpassword',
            'password_confirmation' => 'changedpassword',
        ]);

        $response->assertStatus(200);
    }
}
