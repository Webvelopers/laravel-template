<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\from;
use function Pest\Laravel\withSession;

it('stores the selected locale in session', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user)
        ->from(route('profile'))
        ->post(route('locale.update'), ['locale' => 'en'])
        ->assertRedirect(route('profile'));

    $this->assertSame('en', session('locale'));
});

it('stores spanish locale in session', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    actingAs($user)
        ->from(route('profile'))
        ->post(route('locale.update'), ['locale' => 'es'])
        ->assertRedirect(route('profile'));

    $this->assertSame('es', session('locale'));
});

it('uses the locale stored in session on the next request', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    withSession(['locale' => 'en'])
        ->actingAs($user)
        ->get(route('profile'))
        ->assertOk()
        ->assertSee('Account settings')
        ->assertSee('Language');
});

it('rejects unsupported locales', function (): void {
    from(route('home'))
        ->post(route('locale.update'), ['locale' => 'fr'])
        ->assertRedirect(route('home'))
        ->assertSessionHasErrors('locale');
});
