<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\AppSetting;
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
        $supportedLocales = ['en', 'es'];
        $supportedTemplates = ['default', 'shadcn'];
        $locale = $request->session()->get('locale', config('app.locale'));
        $frontendTemplate = $request->session()->get('frontend_template', 'default');
        $userTemplate = $request->user()?->frontend_template;

        if (is_string($locale) && in_array($locale, $supportedLocales, true)) {
            app()->setLocale($locale);
        }

        if (is_string($userTemplate) && in_array($userTemplate, $supportedTemplates, true)) {
            $frontendTemplate = $userTemplate;
            $request->session()->put('frontend_template', $frontendTemplate);
        }

        if (! is_string($frontendTemplate) || ! in_array($frontendTemplate, $supportedTemplates, true)) {
            $frontendTemplate = 'default';
        }

        $registrationHumanVerificationEnabled = AppSetting::getBool('registration_human_verification_enabled');

        View::share('frontendTemplate', $frontendTemplate);
        View::share('registrationHumanVerificationEnabled', $registrationHumanVerificationEnabled);
        View::share(
            'humanVerificationImage',
            $registrationHumanVerificationEnabled ? app(HumanVerificationChallenge::class)->image() : null,
        );

        return $next($request);
    }
}
