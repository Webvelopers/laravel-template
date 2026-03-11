<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\DatabaseSeeder;

it('creates the starter admin user when the database seeder runs', function (): void {
    $this->seed(DatabaseSeeder::class);

    $user = User::query()->where('email', 'starter@example.com')->first();

    expect($user)
        ->not->toBeNull()
        ->and($user?->name)->toBe('Starter Admin')
        ->and($user?->email_verified_at)->not->toBeNull();
});
