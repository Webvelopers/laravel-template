<?php

declare(strict_types=1);

use App\Models\AppSetting;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\postJson;

it('loads the auth pages', function (): void {
    get(route('login'))->assertOk();
    get(route('register'))->assertOk();
    get(route('password.request'))->assertOk();
});

it('redirects guests away from protected pages', function (): void {
    get(route('dashboard'))->assertRedirect(route('login'));
    get(route('profile'))->assertRedirect(route('login'));
});

it('shows the generic password reset success message for unknown emails', function (): void {
    Notification::fake();

    from(route('password.request'))
        ->post(route('password.email'), [
            'email' => 'missing@example.com',
        ])
        ->assertRedirect(route('password.request'))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('status', __('passwords.sent'));

    get(route('password.request'))
        ->assertOk()
        ->assertSee(__('passwords.sent'))
        ->assertDontSee(__('passwords.user'));

    Notification::assertNothingSent();
});

it('shows the built-in human verification on the register page only when enabled', function (): void {
    AppSetting::setRegistrationHumanVerificationEnabled(true);

    get(route('register'))
        ->assertOk()
        ->assertSee(__('frontend.auth.register.human_verification'))
        ->assertSee('data:image/svg+xml;base64,')
        ->assertSee('human_verification_answer');

    AppSetting::setRegistrationHumanVerificationEnabled(false);

    get(route('register'))
        ->assertOk()
        ->assertDontSee('human_verification_answer');
});

it('refreshes the human verification image', function (): void {
    AppSetting::setRegistrationHumanVerificationEnabled(true);

    get(route('register'))->assertOk();

    $firstAnswer = session()->get('registration_human_verification.answer');

    from(route('register'))
        ->post(route('human-verification.refresh'))
        ->assertRedirect(route('register'));

    $secondAnswer = session()->get('registration_human_verification.answer');

    expect($firstAnswer)
        ->toBeString()
        ->and($secondAnswer)->toBeString()
        ->and($secondAnswer)->not->toBe($firstAnswer);
});

it('returns a fresh captcha image over json refresh requests', function (): void {
    AppSetting::setRegistrationHumanVerificationEnabled(true);

    get(route('register'))->assertOk();

    $firstAnswer = session()->get('registration_human_verification.answer');

    $response = postJson(route('human-verification.refresh'));

    $response
        ->assertOk()
        ->assertJsonStructure(['image']);

    $secondAnswer = session()->get('registration_human_verification.answer');

    expect($firstAnswer)
        ->toBeString()
        ->and($secondAnswer)->toBeString()
        ->and($secondAnswer)->not->toBe($firstAnswer)
        ->and($response->json('image'))->toStartWith('data:image/svg+xml;base64,');
});
