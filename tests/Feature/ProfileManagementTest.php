<?php

declare(strict_types=1);

use App\Models\AppSetting;
use App\Models\User;
use App\Models\UserFrontendPreference;
use App\Models\UserRoleAssignment;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\from;
use function Pest\Laravel\withSession;

it('updates profile information and resets email verification when email changes', function (): void {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    from(route('profile'))
        ->put(route('user-profile-information.update'), [
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

    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    from(route('profile'))
        ->put(route('user-profile-information.update'), [
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
    /** @var User $user */
    $user = User::factory()->create([
        'password' => Hash::make('OldPassword123!'),
    ]);

    actingAs($user);

    from(route('profile'))
        ->put(route('user-password.update'), [
            'current_password' => 'OldPassword123!',
            'password' => 'T3mplate!Fresh#654',
            'password_confirmation' => 'T3mplate!Fresh#654',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasNoErrors();

    expect(Hash::check('T3mplate!Fresh#654', (string) $user->fresh()?->password))->toBeTrue();
});

it('rejects password updates when the current password is invalid', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'password' => Hash::make('OldPassword123!'),
    ]);

    actingAs($user);

    from(route('profile'))
        ->put(route('user-password.update'), [
            'current_password' => 'WrongPassword123!',
            'password' => 'T3mplate!Fresh#654',
            'password_confirmation' => 'T3mplate!Fresh#654',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasErrorsIn('updatePassword', ['current_password']);

    expect(Hash::check('OldPassword123!', (string) $user->fresh()?->password))->toBeTrue();
});

it('updates the frontend template preference from the profile area', function (): void {
    /** @var User $user */
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

    expect(UserFrontendPreference::templateFor($user->fresh()))->toBe('shadcn');

    actingAs($user);

    withSession(['frontend_template' => 'shadcn'])
        ->get(route('home'))
        ->assertOk()
        ->assertSee(__('frontend.templates.shadcn_headline'));
});

it('updates the global human verification setting from the profile area', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($user, App\Enums\UserRole::Admin);

    actingAs($user);

    from(route('profile'))
        ->post(route('human-verification.update'), [
            'registration_human_verification_enabled' => '1',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasNoErrors();

    expect(AppSetting::registrationHumanVerificationEnabled())->toBeTrue();
});

it('does not allow guests to update the global human verification setting', function (): void {
    from(route('login'))
        ->post(route('human-verification.update'), [
            'registration_human_verification_enabled' => '1',
        ])
        ->assertRedirect(route('login'));

    expect(AppSetting::registrationHumanVerificationEnabled())->toBeFalse();
});

it('does not allow standard users to update the global human verification setting', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($user, App\Enums\UserRole::User);

    actingAs($user)
        ->post(route('human-verification.update'), [
            'registration_human_verification_enabled' => '1',
        ])
        ->assertForbidden();

    expect(AppSetting::registrationHumanVerificationEnabled())->toBeFalse();
});

it('rejects invalid frontend template selections', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user);

    from(route('profile'))
        ->post(route('frontend-template.update'), [
            'frontend_template' => 'invalid-template',
        ])
        ->assertRedirect(route('profile'))
        ->assertSessionHasErrors('frontend_template');

    expect(UserFrontendPreference::templateFor($user->fresh()))->toBeNull();
});
