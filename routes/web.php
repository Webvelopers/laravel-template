<?php

declare(strict_types=1);

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::redirect('/home', '/dashboard');

Route::post('/locale', function (Request $request): RedirectResponse {
    $validated = $request->validate([
        'locale' => ['required', 'in:en,es'],
    ]);

    $request->session()->put('locale', $validated['locale']);

    return back();
})->name('locale.update');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
});
