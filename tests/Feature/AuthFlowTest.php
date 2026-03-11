<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('registers a user with a normalized email address', function (): void {
    $response = $this->post(route('register'), [
        'name' => 'Starter User',
        'email' => 'STARTER@EXAMPLE.COM',
        'password' => 'T3mplate!Safe#987',
        'password_confirmation' => 'T3mplate!Safe#987',
    ]);

    $response->assertRedirect('/dashboard');

    $user = User::query()->where('email', 'starter@example.com')->first();

    expect($user)
        ->not->toBeNull()
        ->and($user?->name)->toBe('Starter User')
        ->and(Hash::check('T3mplate!Safe#987', (string) $user?->password))->toBeTrue();

    $this->assertAuthenticated();
});

it('logs in verified users and redirects them to the dashboard', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('Password123!'),
        'email_verified_at' => now(),
    ]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'Password123!',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

it('logs out authenticated users', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});
