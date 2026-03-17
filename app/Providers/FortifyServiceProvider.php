<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Responses\Fortify\SendPasswordResetLinkResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Fortify;

final class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FailedPasswordResetLinkRequestResponse::class, SendPasswordResetLinkResponse::class);
        $this->app->singleton(SuccessfulPasswordResetLinkRequestResponse::class, SendPasswordResetLinkResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::loginView(fn (): \Illuminate\Contracts\View\View => view('auth.login'));
        Fortify::registerView(fn (): \Illuminate\Contracts\View\View => view('auth.register'));
        Fortify::requestPasswordResetLinkView(fn (): \Illuminate\Contracts\View\View => view('auth.forgot-password'));
        Fortify::resetPasswordView(fn (Request $request): \Illuminate\Contracts\View\View => view('auth.reset-password', ['request' => $request]));
        Fortify::verifyEmailView(fn (): \Illuminate\Contracts\View\View => view('auth.verify-email'));
        Fortify::confirmPasswordView(fn (): \Illuminate\Contracts\View\View => view('auth.confirm-password'));
        Fortify::twoFactorChallengeView(fn (): \Illuminate\Contracts\View\View => view('auth.two-factor-challenge'));

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        $loginRateLimit = max($this->integerConfig('fortify.login_rate_limit', 5), 1);
        $twoFactorRateLimit = max($this->integerConfig('fortify.two_factor_rate_limit', 5), 1);

        RateLimiter::for('login', function (Request $request) use ($loginRateLimit): Limit {
            $throttleKey = Str::transliterate(Str::lower($request->string(Fortify::username())->toString()).'|'.$request->ip());

            return Limit::perMinute($loginRateLimit)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) use ($twoFactorRateLimit): Limit {
            $loginId = $request->session()->get('login.id');

            return Limit::perMinute($twoFactorRateLimit)->by(is_scalar($loginId) ? (string) $loginId : 'two-factor');
        });
    }

    private function integerConfig(string $key, int $default): int
    {
        $value = config($key, $default);

        return is_numeric($value) ? (int) $value : $default;
    }
}
