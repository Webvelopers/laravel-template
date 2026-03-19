<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Enums\UserRole;
use App\Models\AppSetting;
use App\Models\User;
use App\Models\UserRoleAssignment;
use App\Support\HumanVerificationChallenge;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

final readonly class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function __construct(private HumanVerificationChallenge $humanVerificationChallenge) {}

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        $humanVerificationEnabled = AppSetting::registrationHumanVerificationEnabled();

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'human_verification_answer' => $humanVerificationEnabled ? ['required', 'string'] : ['nullable', 'string'],
        ])->validate();

        if ($humanVerificationEnabled && ! $this->humanVerificationChallenge->verify($input['human_verification_answer'] ?? null)) {
            $this->humanVerificationChallenge->refresh();

            throw ValidationException::withMessages([
                'human_verification_answer' => __('frontend.auth.register.human_verification_failed'),
            ]);
        }

        $this->humanVerificationChallenge->clear();

        $user = User::create([
            'name' => $input['name'],
            'email' => mb_strtolower($input['email']),
            'password' => Hash::make($input['password']),
        ]);

        UserRoleAssignment::assign($user, UserRole::User);

        return $user;
    }
}
