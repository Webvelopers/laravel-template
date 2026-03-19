<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserRoleAssignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $starterAdmin = User::query()->updateOrCreate(
            ['email' => 'starter@example.com'],
            [
                'name' => 'Starter Admin',
                'email_verified_at' => now(),
                'password' => 'password',
            ],
        );
        UserRoleAssignment::assign($starterAdmin, UserRole::Admin);

        $operationsAdmin = User::query()->updateOrCreate(
            ['email' => 'ops-admin@example.com'],
            [
                'name' => 'Operations Admin',
                'email_verified_at' => now(),
                'password' => 'password',
            ],
        );
        UserRoleAssignment::assign($operationsAdmin, UserRole::Admin);
    }
}
