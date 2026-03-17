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

<x-layouts.app :title="__('frontend.auth.login.title')">
    <section class="{{ $cardClass }}">
        <p class="{{ $eyebrowClass }}">
            {{ __('frontend.auth.login.eyebrow') }}
        </p>
        <h1 class="{{ $titleClass }}">{{ __('frontend.auth.login.headline') }}</h1>
        <p class="{{ $copyClass }}">{{ __('frontend.auth.login.description') }}</p>

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-4">
            @csrf

            <x-auth-session-status :status="session('status')" />

            <label class="{{ $labelClass }}">
                <span>{{ __('frontend.auth.email') }}</span>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="{{ $inputClass }}"
                />
            </label>
            <x-input-error :messages="$errors->get('email')" />

            <label class="{{ $labelClass }}">
                <span>{{ __('frontend.auth.password') }}</span>
                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="{{ $inputClass }}"
                />
            </label>
            <x-input-error :messages="$errors->get('password')" />

            <label
                class="{{ $isShadcn ? 'flex items-center gap-3 text-sm text-slate-600' : 'flex items-center gap-3 text-sm text-stone-600' }}"
            >
                <input
                    type="checkbox"
                    name="remember"
                    class="{{ $isShadcn ? 'rounded border-slate-300 text-slate-900 focus:ring-slate-900' : 'rounded border-stone-300 text-stone-900 focus:ring-stone-900' }}"
                />
                <span>{{ __('frontend.auth.remember') }}</span>
            </label>

            <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                <a href="{{ route('password.request') }}" class="{{ $linkClass }}">
                    {{ __('frontend.auth.login.forgot') }}
                </a>
                <button type="submit" class="{{ $buttonClass }}">
                    {{ __('frontend.auth.login.submit') }}
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
