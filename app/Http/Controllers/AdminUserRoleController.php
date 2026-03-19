<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use App\Models\UserRoleAssignment;
use Illuminate\Http\RedirectResponse;

final class AdminUserRoleController extends Controller
{
    public function update(UpdateUserRoleRequest $request, User $user): RedirectResponse
    {
        abort_if($request->user() !== null && $request->user()->is($user), 422, __('frontend.admin.role_self_update_forbidden'));

        UserRoleAssignment::assign(
            $user,
            UserRole::from($request->string('role')->toString()),
        );

        return back()->with('status', 'user-role-updated');
    }
}
