<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFrontendTemplateRequest;
use App\Models\UserFrontendPreference;
use Illuminate\Http\RedirectResponse;

final class FrontendTemplateController extends Controller
{
    public function __invoke(UpdateFrontendTemplateRequest $request): RedirectResponse
    {
        $template = $request->string('frontend_template')->toString();

        if ($request->user() !== null) {
            UserFrontendPreference::updateTemplateFor($request->user(), $template);
        }

        $request->session()->put('frontend_template', $template);

        return back()->with('status', 'frontend-template-updated');
    }
}
