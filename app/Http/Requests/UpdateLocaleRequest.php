<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateLocaleRequest extends FormRequest
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
        /** @var list<string> $supportedLocales */
        $supportedLocales = config('frontend.locales.supported', []);

        return [
            'locale' => ['required', 'string', Rule::in($supportedLocales)],
        ];
    }
}
