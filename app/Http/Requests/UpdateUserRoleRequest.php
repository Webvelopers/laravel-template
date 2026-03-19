<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        /** @var list<string> $roles */
        $roles = collect(\App\Enums\UserRole::cases())
            ->map(static fn (\App\Enums\UserRole $role): string => $role->value)
            ->all();

        return [
            'role' => ['required', 'string', Rule::in($roles)],
        ];
    }
}
