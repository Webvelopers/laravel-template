<?php

declare(strict_types=1);

use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\from;
use function Pest\Laravel\withSession;

it('updates profile information and resets email verification when email changes', function (): void {
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    from(route('profile'))
        ->put('/user/profile-information', [
            'name' => 'Updated User',
            'email' => 'UPDATED@EXAMPLE.COM',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasNoErrors();

    $user->refresh();

    expect($user->name)->toBe('Updated User')
        ->and($user->email)->toBe('updated@example.com')
        ->and($user->email_verified_at)->toBeNull();

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('updates the user name without clearing verification when email stays the same', function (): void {
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    from(route('profile'))
        ->put('/user/profile-information', [
            'name' => 'Only Name Changed',
            'email' => $user->email,
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasNoErrors();

    $user->refresh();

    expect($user->name)->toBe('Only Name Changed')
        ->and($user->email_verified_at)->not->toBeNull();

    Notification::assertNothingSent();
});

it('updates the password when the current password is valid', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('OldPassword123!'),
    ]);

    actingAs($user);

    from(route('profile'))
        ->put('/user/password', [
            'current_password' => 'OldPassword123!',
            'password' => 'T3mplate!Fresh#654',
            'password_confirmation' => 'T3mplate!Fresh#654',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasNoErrors();

    expect(Hash::check('T3mplate!Fresh#654', (string) $user->fresh()?->password))->toBeTrue();
});

it('rejects password updates when the current password is invalid', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('OldPassword123!'),
    ]);

    actingAs($user);

    from(route('profile'))
        ->put('/user/password', [
            'current_password' => 'WrongPassword123!',
            'password' => 'T3mplate!Fresh#654',
            'password_confirmation' => 'T3mplate!Fresh#654',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasErrorsIn('updatePassword', ['current_password']);

    expect(Hash::check('OldPassword123!', (string) $user->fresh()?->password))->toBeTrue();
});

it('updates the frontend template preference from the profile area', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    from(route('profile'))
        ->post(route('frontend-template.update'), [
            'frontend_template' => 'shadcn',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('frontend_template', 'shadcn');

    expect($user->fresh()?->frontend_template)->toBe('shadcn');

    actingAs($user);

    withSession(['frontend_template' => 'shadcn'])
        ->get(route('home'))
        ->assertOk()
        ->assertSee(__('frontend.templates.shadcn_headline'));
});

it('updates the global human verification setting from the profile area', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    from(route('profile'))
        ->post(route('human-verification.update'), [
            'registration_human_verification_enabled' => '1',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasNoErrors();

    expect(AppSetting::getBool('registration_human_verification_enabled'))->toBeTrue();
});
