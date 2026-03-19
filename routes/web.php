<?php

declare(strict_types=1);

use App\Http\Controllers\AdminRoleCapabilityController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminUserRoleController;
use App\Http\Controllers\FrontendTemplateController;
use App\Http\Controllers\HumanVerificationController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\TemplatePreviewController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('/templates', 'templates.index')->name('templates.index');

Route::get('/templates/{template}', TemplatePreviewController::class)->name('templates.show');

Route::redirect('/home', '/dashboard');

Route::post('/locale', LocaleController::class)->name('locale.update');

Route::post('/frontend-template', FrontendTemplateController::class)->name('frontend-template.update');

Route::post('/human-verification', [HumanVerificationController::class, 'update'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('human-verification.update');

Route::post('/human-verification/refresh', [HumanVerificationController::class, 'refresh'])->name('human-verification.refresh');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function (): void {
    Route::get('/admin/settings', AdminSettingsController::class)->name('admin.settings');
    Route::put('/admin/users/{user}/role', [AdminUserRoleController::class, 'update'])->name('admin.users.role.update');
    Route::put('/admin/roles/{role}/capabilities', [AdminRoleCapabilityController::class, 'update'])->name('admin.roles.capabilities.update');
});
