<?php

declare(strict_types=1);

use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('registers a user with a normalized email address', function (): void {
    $response = post(route('register'), [
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
        ->and(Hash::check('T3mplate!Safe#987', (string) $user?->password))->toBeTrue()
        ->and(Auth::check())->toBeTrue();
});

it('requires human verification on registration when enabled', function (): void {
    AppSetting::setBool('registration_human_verification_enabled', true);

    get(route('register'))->assertOk();

    $response = from(route('register'))->post(route('register'), [
        'name' => 'Starter User',
        'email' => 'starter@example.com',
        'password' => 'T3mplate!Safe#987',
        'password_confirmation' => 'T3mplate!Safe#987',
        'human_verification_answer' => 'wrong',
    ]);

    $response->assertRedirect(route('register'));
    $response->assertSessionHasErrors(['human_verification_answer']);
});

it('registers a user when human verification succeeds', function (): void {
    AppSetting::setBool('registration_human_verification_enabled', true);

    get(route('register'))->assertOk();

    $answer = session()->get('registration_human_verification.answer');

    $response = post(route('register'), [
        'name' => 'Verified Human',
        'email' => 'verified@example.com',
        'password' => 'T3mplate!Safe#987',
        'password_confirmation' => 'T3mplate!Safe#987',
        'human_verification_answer' => is_string($answer) ? $answer : '',
    ]);

    $response->assertRedirect('/dashboard');

    expect(User::query()->where('email', 'verified@example.com')->exists())->toBeTrue();
});

it('logs in verified users and redirects them to the dashboard', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('Password123!'),
        'email_verified_at' => now(),
    ]);

    post(route('login'), [
        'email' => $user->email,
        'password' => 'Password123!',
    ])->assertRedirect('/dashboard');

    expect(Auth::id())->toBe($user->id);
});

it('logs out authenticated users', function (): void {
    $user = User::factory()->create();

    actingAs($user);

    post(route('logout'))->assertRedirect('/');

    expect(Auth::check())->toBeFalse();
});
