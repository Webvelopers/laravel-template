<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Crypt;

it('shows the qr prompt while two factor authentication is pending confirmation', function (): void {
    $user = User::factory()->create([
        'two_factor_secret' => Crypt::encrypt('pending-secret'),
        'two_factor_recovery_codes' => Crypt::encrypt(json_encode(['code-1', 'code-2'])),
        'two_factor_confirmed_at' => null,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('profile'))
        ->assertOk()
        ->assertSee(__('frontend.profile.scan_qr'))
        ->assertSee(__('frontend.profile.confirm_2fa'));
});

it('hides the qr prompt and shows recovery codes after two factor confirmation', function (): void {
    $user = User::factory()->create([
        'two_factor_secret' => Crypt::encrypt('confirmed-secret'),
        'two_factor_recovery_codes' => Crypt::encrypt(json_encode(['recovery-one', 'recovery-two'])),
        'two_factor_confirmed_at' => now(),
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('profile'))
        ->assertOk()
        ->assertDontSee(__('frontend.profile.scan_qr'))
        ->assertDontSee(__('frontend.profile.confirm_2fa'))
        ->assertSee(__('frontend.profile.recovery_codes'))
        ->assertSee('recovery-one')
        ->assertSee('recovery-two');
});
