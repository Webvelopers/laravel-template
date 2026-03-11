<?php

declare(strict_types=1);

use App\Models\User;

it('casts password and verification fields for the starter template', function (): void {
    $user = new User();

    expect($user->getCasts())
        ->toMatchArray([
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ]);
});

it('hides sensitive authentication attributes', function (): void {
    $user = new User();

    expect($user->getHidden())
        ->toContain('password')
        ->toContain('remember_token')
        ->toContain('two_factor_secret')
        ->toContain('two_factor_recovery_codes');
});
