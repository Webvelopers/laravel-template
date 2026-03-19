<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\AppSetting;
use App\Models\UserFrontendPreference;
use App\Models\UserRoleAssignment;
use App\Support\HumanVerificationChallenge;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

final class SetLocale
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var list<string> $supportedLocales */
        $supportedLocales = config('frontend.locales.supported', []);
        /** @var list<string> $supportedTemplates */
        $supportedTemplates = config('frontend.templates.supported', []);
        $defaultLocale = config('frontend.locales.default', config('app.locale'));
        $defaultTemplate = config('frontend.templates.default', 'default');
        $locale = $request->session()->get('locale', $defaultLocale);
        $frontendTemplate = $request->session()->get('frontend_template', $defaultTemplate);
        $userTemplate = UserFrontendPreference::templateFor($request->user());
        $currentUserRole = UserRoleAssignment::roleFor($request->user());

        if (is_string($locale) && in_array($locale, $supportedLocales, true)) {
            app()->setLocale($locale);
        }

        if (is_string($userTemplate) && in_array($userTemplate, $supportedTemplates, true)) {
            $frontendTemplate = $userTemplate;
            $request->session()->put('frontend_template', $frontendTemplate);
        }

        if (! is_string($frontendTemplate) || ! in_array($frontendTemplate, $supportedTemplates, true)) {
            $frontendTemplate = $defaultTemplate;
        }

        $registrationHumanVerificationEnabled = AppSetting::registrationHumanVerificationEnabled();

        View::share('frontendTemplate', $frontendTemplate);
        View::share('currentUserRole', $currentUserRole);
        View::share('registrationHumanVerificationEnabled', $registrationHumanVerificationEnabled);
        View::share(
            'humanVerificationImage',
            $registrationHumanVerificationEnabled ? app(HumanVerificationChallenge::class)->image() : null,
        );

        return $next($request);
    }
}
