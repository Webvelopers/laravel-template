<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserRoleAssignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class StandardUserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $starterMember = User::query()->updateOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Starter Member',
                'email_verified_at' => now(),
                'password' => 'password',
            ],
        );
        UserRoleAssignment::assign($starterMember, UserRole::User);

        $dataAnalyst = User::query()->updateOrCreate(
            ['email' => 'analyst@example.com'],
            [
                'name' => 'Data Analyst',
                'email_verified_at' => now(),
                'password' => 'password',
            ],
        );
        UserRoleAssignment::assign($dataAnalyst, UserRole::User);

        User::factory()->count(3)->create()->each(static function (User $user): void {
            UserRoleAssignment::assign($user, UserRole::User);
        });
    }
}
