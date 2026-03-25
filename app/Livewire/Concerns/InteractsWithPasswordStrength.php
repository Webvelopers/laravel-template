<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Illuminate\Validation\Rules\Password;
use Throwable;

trait InteractsWithPasswordStrength
{
    use PasswordValidationRules;

    public function minimumLength(): int
    {
        return $this->integerRuleValue($this->resolvePasswordRule()?->appliedRules()['min'] ?? null, 8);
    }

    /**
     * @return array{
     *     score: int,
     *     percentage: int,
     *     label: string,
     *     checks: array<string, bool>
     * }
     */
    protected function passwordStrength(string $password): array
    {
        $passwordRule = $this->resolvePasswordRule();
        $appliedRules = $passwordRule?->appliedRules() ?? [];
        $minimumLength = $this->minimumLength();
        $requiresMixedCase = (bool) ($appliedRules['mixedCase'] ?? false);
        $requiresNumbers = (bool) ($appliedRules['numbers'] ?? false);
        $requiresSymbols = (bool) ($appliedRules['symbols'] ?? false);
        $requiresUncompromised = (bool) ($appliedRules['uncompromised'] ?? false);
        $compromisedThreshold = $this->integerRuleValue($appliedRules['compromisedThreshold'] ?? null);

        $checks = [
            'length' => mb_strlen($password) >= $minimumLength,
            'mixed_case' => ! $requiresMixedCase || preg_match('/(?=.*\p{Ll})(?=.*\p{Lu})/u', $password) === 1,
            'number' => ! $requiresNumbers || preg_match('/\pN/u', $password) === 1,
            'symbol' => ! $requiresSymbols || preg_match('/\p{Z}|\p{S}|\p{P}/u', $password) === 1,
            'uncompromised' => ! $requiresUncompromised || $this->passwordIsUncompromised($password, $compromisedThreshold),
        ];

        $activeChecks = [
            'length' => true,
            'mixed_case' => $requiresMixedCase,
            'number' => $requiresNumbers,
            'symbol' => $requiresSymbols,
            'uncompromised' => $requiresUncompromised,
        ];

        $score = count(array_filter(array_intersect_key($checks, array_filter($activeChecks))));
        $maxScore = max(count(array_filter($activeChecks)), 1);

        return [
            'score' => $score,
            'percentage' => (int) round(($score / $maxScore) * 100),
            'label' => match (true) {
                $password === '' => __('frontend.password_strength.empty'),
                $score <= max(1, (int) floor($maxScore / 2)) => __('frontend.password_strength.weak'),
                $score < $maxScore => __('frontend.password_strength.medium'),
                default => __('frontend.password_strength.strong'),
            },
            'checks' => $checks,
        ];
    }

    private function resolvePasswordRule(): ?Password
    {
        foreach ($this->passwordRules() as $rule) {
            if ($rule instanceof Password) {
                return $rule;
            }
        }

        return null;
    }

    private function passwordIsUncompromised(string $password, int $threshold): bool
    {
        if ($password === '') {
            return false;
        }

        try {
            return app(UncompromisedVerifier::class)->verify([
                'value' => $password,
                'threshold' => $threshold,
            ]);
        } catch (Throwable) {
            return true;
        }
    }

    private function integerRuleValue(mixed $value, int $default = 0): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && is_numeric($value)) {
            return (int) $value;
        }

        return $default;
    }
}
