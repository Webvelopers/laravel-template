<?php

declare(strict_types=1);

use App\Models\AppSetting;
use App\Support\HumanVerificationChallenge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::view('/', 'welcome')->name('home');

Route::view('/templates', 'templates.index')->name('templates.index');

Route::get('/templates/{template}', function (string $template): View {
    abort_unless(in_array($template, ['default', 'shadcn'], true), 404);

    return view('templates.preview', [
        'template' => $template,
    ]);
})->name('templates.show');

Route::redirect('/home', '/dashboard');

Route::post('/locale', function (Request $request): RedirectResponse {
    $validated = $request->validate([
        'locale' => ['required', 'in:en,es'],
    ]);

    $request->session()->put('locale', $validated['locale']);

    return back();
})->name('locale.update');

Route::post('/frontend-template', function (Request $request): RedirectResponse {
    $validated = $request->validate([
        'frontend_template' => ['required', 'in:default,shadcn'],
    ]);

    $request->user()?->forceFill([
        'frontend_template' => $validated['frontend_template'],
    ])->save();

    $request->session()->put('frontend_template', $validated['frontend_template']);

    return back()->with('status', 'frontend-template-updated');
})->name('frontend-template.update');

Route::post('/human-verification', function (Request $request): RedirectResponse {
    $validated = $request->validate([
        'registration_human_verification_enabled' => ['required', 'boolean'],
    ]);

    AppSetting::setBool('registration_human_verification_enabled', (bool) $validated['registration_human_verification_enabled']);

    return back()->with('status', 'human-verification-updated');
})->name('human-verification.update');

Route::post('/human-verification/refresh', function (Request $request, HumanVerificationChallenge $humanVerificationChallenge): JsonResponse|RedirectResponse {
    $humanVerificationChallenge->refresh();

    if ($request->wantsJson()) {
        return new JsonResponse([
            'image' => $humanVerificationChallenge->image(),
        ]);
    }

    return back();
})->name('human-verification.refresh');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
});
