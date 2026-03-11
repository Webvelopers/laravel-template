<?php

declare(strict_types=1);

use App\Models\User;

it('stores the selected locale in session', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)
        ->from(route('profile'))
        ->post(route('locale.update'), ['locale' => 'en'])
        ->assertRedirect(route('profile'));

    $this->assertSame('en', session('locale'));
});

it('stores spanish locale in session', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)
        ->from(route('profile'))
        ->post(route('locale.update'), ['locale' => 'es'])
        ->assertRedirect(route('profile'));

    $this->assertSame('es', session('locale'));
});

it('uses the locale stored in session on the next request', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->withSession(['locale' => 'en'])
        ->actingAs($user)
        ->get(route('profile'))
        ->assertOk()
        ->assertSee('Account settings')
        ->assertSee('Language');
});
