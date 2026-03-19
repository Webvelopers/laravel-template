<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateFrontendTemplateRequest extends FormRequest
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
        /** @var list<string> $supportedTemplates */
        $supportedTemplates = config('frontend.templates.supported', []);

        return [
            'frontend_template' => ['required', 'string', Rule::in($supportedTemplates)],
        ];
    }
}
