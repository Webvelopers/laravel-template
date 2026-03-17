@php
    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';
    $cardClass = $isShadcn ? 'mx-auto max-w-xl rounded-[1.5rem] border border-slate-200 bg-white p-8 shadow-[0_20px_60px_-36px_rgba(15,23,42,0.25)]' : 'mx-auto max-w-xl rounded-[2rem] border border-stone-200 bg-white/90 p-8 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]';
    $eyebrowClass = $isShadcn ? 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase' : 'text-sm font-semibold tracking-[0.3em] text-amber-700 uppercase';
    $titleClass = $isShadcn ? 'mt-3 text-4xl font-semibold tracking-tight text-slate-950' : 'font-display mt-3 text-4xl text-stone-950';
    $copyClass = $isShadcn ? 'mt-3 text-base leading-7 text-slate-600' : 'mt-3 text-base leading-7 text-stone-600';
    $labelClass = $isShadcn ? 'block space-y-2 text-sm font-medium text-slate-700' : 'block space-y-2 text-sm font-medium text-stone-700';
    $inputClass = $isShadcn ? 'w-full rounded-md border border-slate-300 bg-white px-4 py-3 text-slate-900 transition outline-none focus:border-slate-950 focus:ring-2 focus:ring-slate-950/10' : 'w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white';
    $linkClass = $isShadcn ? 'text-sm font-medium text-slate-700 underline underline-offset-4' : 'text-sm font-semibold text-stone-700 underline underline-offset-4';
    $buttonClass = $isShadcn ? 'rounded-md bg-slate-950 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800' : 'rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700';
@endphp

<x-layouts.app :title="__('frontend.auth.register.title')">
    <section class="{{ $cardClass }}">
        <p class="{{ $eyebrowClass }}">
            {{ __('frontend.auth.register.eyebrow') }}
        </p>
        <h1 class="{{ $titleClass }}">{{ __('frontend.auth.register.headline') }}</h1>
        <p class="{{ $copyClass }}">{{ __('frontend.auth.register.description') }}</p>

        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-4">
            @csrf

            <label class="{{ $labelClass }}">
                <span>{{ __('frontend.auth.register.name') }}</span>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    class="{{ $inputClass }}"
                />
            </label>
            <x-input-error :messages="$errors->get('name')" />

            <label class="{{ $labelClass }}">
                <span>{{ __('frontend.auth.email') }}</span>
                <input type="email" name="email" value="{{ old('email') }}" required class="{{ $inputClass }}" />
            </label>
            <x-input-error :messages="$errors->get('email')" />

            <label class="{{ $labelClass }}">
                <span>{{ __('frontend.auth.password') }}</span>
                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="{{ $inputClass }}"
                />
            </label>
            <x-input-error :messages="$errors->get('password')" />

            <label class="{{ $labelClass }}">
                <span>{{ __('frontend.auth.register.confirm_password') }}</span>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="{{ $inputClass }}"
                />
            </label>

            @if ($registrationHumanVerificationEnabled && filled($humanVerificationImage))
                <div class="space-y-2">
                    <p class="{{ $labelClass }}">{{ __('frontend.auth.register.human_verification') }}</p>
                    <div
                        class="{{ $isShadcn ? 'rounded-2xl border border-slate-200 bg-slate-50 p-4' : 'rounded-2xl border border-stone-200 bg-stone-50 p-4' }}"
                    >
                        <div class="flex flex-col gap-3 md:flex-row md:items-center">
                            <img
                                src="{{ $humanVerificationImage }}"
                                alt="{{ __('frontend.auth.register.human_verification_image_alt') }}"
                                data-human-verification-image
                                class="h-20 w-[220px] rounded-2xl border border-slate-200 bg-white object-cover"
                            />
                            <div class="space-y-3">
                                <p
                                    class="{{ $isShadcn ? 'text-sm leading-6 text-slate-600' : 'text-sm leading-6 text-stone-600' }}"
                                >
                                    {{ __('frontend.auth.register.human_verification_hint') }}
                                </p>
                                <form method="POST" action="{{ route('human-verification.refresh') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        data-human-verification-refresh
                                        class="{{ $isShadcn ? 'rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-white' : 'rounded-full border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700 transition hover:bg-white' }}"
                                    >
                                        {{ __('frontend.auth.register.refresh_human_verification') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <input
                            type="text"
                            name="human_verification_answer"
                            value="{{ old('human_verification_answer') }}"
                            inputmode="text"
                            autocomplete="off"
                            class="{{ $inputClass }} mt-3"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('human_verification_answer')" />
                </div>
            @endif

            <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                <a href="{{ route('login') }}" class="{{ $linkClass }}">
                    {{ __('frontend.auth.register.have_account') }}
                </a>
                <button type="submit" class="{{ $buttonClass }}">
                    {{ __('frontend.auth.register.submit') }}
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
