<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UpdateRoleCapabilitiesRequest;
use App\Support\RoleCapabilityMatrix;
use Illuminate\Http\RedirectResponse;

final class AdminRoleCapabilityController extends Controller
{
    public function update(UpdateRoleCapabilitiesRequest $request, string $role): RedirectResponse
    {
        $resolvedRole = UserRole::from($role);

        /** @var list<string> $capabilities */
        $capabilities = $request->input('capabilities', []);

        RoleCapabilityMatrix::update($resolvedRole, $capabilities);

        return back()->with('status', 'role-capabilities-updated');
    }
}
