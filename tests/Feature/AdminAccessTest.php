<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserRoleAssignment;
use App\Support\RoleCapabilityMatrix;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\from;

it('allows administrators to access the administration settings page', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($user, UserRole::Admin);

    actingAs($user)
        ->get(route('admin.settings'))
        ->assertOk()
        ->assertSee(__('frontend.admin.headline'))
        ->assertSee(__('frontend.admin.roles_title'))
        ->assertSee(__('frontend.admin.user_roles_title'))
        ->assertSee(__('frontend.admin.update_capabilities'));
});

it('forbids standard users from accessing the administration settings page', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($user, UserRole::User);

    actingAs($user)
        ->get(route('admin.settings'))
        ->assertForbidden();
});

it('allows administrators to update the role assigned to another user', function (): void {
    /** @var User $admin */
    $admin = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($admin, UserRole::Admin);

    /** @var User $member */
    $member = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($member, UserRole::User);

    from(route('admin.settings'))
        ->actingAs($admin)
        ->put(route('admin.users.role.update', $member), [
            'role' => UserRole::Admin->value,
        ])
        ->assertRedirect(route('admin.settings'))
        ->assertSessionHas('status', 'user-role-updated');

    expect(UserRoleAssignment::roleFor($member))->toBe(UserRole::Admin);
});

it('prevents administrators from changing their own role from the admin screen', function (): void {
    /** @var User $admin */
    $admin = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($admin, UserRole::Admin);

    from(route('admin.settings'))
        ->actingAs($admin)
        ->put(route('admin.users.role.update', $admin), [
            'role' => UserRole::User->value,
        ])
        ->assertStatus(422);

    expect(UserRoleAssignment::roleFor($admin))->toBe(UserRole::Admin);
});

it('forbids standard users from updating user roles', function (): void {
    /** @var User $standardUser */
    $standardUser = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($standardUser, UserRole::User);

    /** @var User $targetUser */
    $targetUser = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($targetUser, UserRole::User);

    actingAs($standardUser)
        ->put(route('admin.users.role.update', $targetUser), [
            'role' => UserRole::Admin->value,
        ])
        ->assertForbidden();

    expect(UserRoleAssignment::roleFor($targetUser))->toBe(UserRole::User);
});

it('allows administrators to update configurable capabilities for a role', function (): void {
    /** @var User $admin */
    $admin = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($admin, UserRole::Admin);

    from(route('admin.settings'))
        ->actingAs($admin)
        ->put(route('admin.roles.capabilities.update', UserRole::User->value), [
            'capabilities' => [
                'dashboard.access',
                'profile.manage_own',
                'frontend.choose_template',
                'admin.manage_settings',
            ],
        ])
        ->assertRedirect(route('admin.settings'))
        ->assertSessionHas('status', 'role-capabilities-updated');

    expect(RoleCapabilityMatrix::capabilitiesFor(UserRole::User))
        ->toContain('admin.manage_settings')
        ->toContain('dashboard.access');
});

it('keeps protected administrator capabilities even if they are omitted in the update payload', function (): void {
    /** @var User $admin */
    $admin = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($admin, UserRole::Admin);

    from(route('admin.settings'))
        ->actingAs($admin)
        ->put(route('admin.roles.capabilities.update', UserRole::Admin->value), [
            'capabilities' => ['profile.manage_own'],
        ])
        ->assertRedirect(route('admin.settings'));

    expect(RoleCapabilityMatrix::capabilitiesFor(UserRole::Admin))
        ->toContain('admin.access')
        ->toContain('admin.manage_roles')
        ->toContain('admin.manage_settings')
        ->toContain('profile.manage_own');
});

it('forbids standard users from updating role capabilities', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    UserRoleAssignment::assign($user, UserRole::User);

    actingAs($user)
        ->put(route('admin.roles.capabilities.update', UserRole::User->value), [
            'capabilities' => ['dashboard.access'],
        ])
        ->assertForbidden();
});
