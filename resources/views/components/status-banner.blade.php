@props([
    'status',
])

@php
    $messages = [
        'profile-information-updated' => __('frontend.status.profile-information-updated'),
        'password-updated' => __('frontend.status.password-updated'),
        'verification-link-sent' => __('frontend.status.verification-link-sent'),
        'two-factor-authentication-enabled' => __('frontend.status.two-factor-authentication-enabled'),
        'two-factor-authentication-disabled' => __('frontend.status.two-factor-authentication-disabled'),
        'two-factor-authentication-confirmed' => __('frontend.status.two-factor-authentication-confirmed'),
        'recovery-codes-generated' => __('frontend.status.recovery-codes-generated'),
    ];
@endphp

@if ($status && array_key_exists($status, $messages))
    <div
        class="{{ ($frontendTemplate ?? 'default') === 'shadcn' ? 'rounded-xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-700' : 'rounded-2xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-700' }}"
    >
        {{ $messages[$status] }}
    </div>
@endif
