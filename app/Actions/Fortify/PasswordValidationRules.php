<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    protected const MIN = 12;

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, Password|string>
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            Password::min(self::MIN)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
            'confirmed',
        ];
    }
}
