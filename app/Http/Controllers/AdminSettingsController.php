<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\UserRoleAssignment;
use App\Support\RoleCapabilityMatrix;
use Illuminate\Support\Collection;
use Illuminate\View\View;

final class AdminSettingsController extends Controller
{
    public function __invoke(): View
    {
        /** @var Collection<int, User> $users */
        $users = User::query()
            ->orderBy('name')
            ->get();

        /** @var array<int, string|UserRole> $rawRoleAssignments */
        $rawRoleAssignments = UserRoleAssignment::query()
            ->pluck('role', 'user_id')
            ->all();

        /** @var array<int, string> $roleAssignments */
        $roleAssignments = collect($rawRoleAssignments)
            ->map(static fn (string|UserRole $role): string => $role instanceof UserRole ? $role->value : $role)
            ->all();

        /** @var list<array{value: string, label: string, capabilities: list<string>}> $availableRoles */
        $availableRoles = collect(UserRole::cases())
            ->map(static fn (UserRole $role): array => [
                'value' => $role->value,
                'label' => __('frontend.roles.'.$role->value),
                'capabilities' => RoleCapabilityMatrix::capabilitiesFor($role),
                'protected_capabilities' => $role->protectedCapabilityKeys(),
            ])
            ->values()
            ->all();

        return view('admin.settings', [
            'users' => $users,
            'roleAssignments' => $roleAssignments,
            'availableRoles' => $availableRoles,
        ]);
    }
}
