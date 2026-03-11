<x-layouts.app :title="__('frontend.profile.title')">
    @php
        $user = auth()->user();
        $twoFactorEnabled = $user->two_factor_secret !== null;
        $twoFactorConfirmed = $user->two_factor_confirmed_at !== null;
    @endphp

    <section class="space-y-8">
        <div class="space-y-2">
            <p class="text-sm font-semibold tracking-[0.35em] text-amber-700 uppercase">
                {{ __('frontend.profile.title') }}
            </p>
            <h1 class="font-display text-4xl text-stone-950">{{ __('frontend.profile.headline') }}</h1>
            <p class="max-w-2xl text-base leading-8 text-stone-600">{{ __('frontend.profile.description') }}</p>
        </div>

        <x-status-banner :status="session('status')" />

        <div class="grid gap-6 lg:grid-cols-2">
            <section
                class="rounded-[2rem] border border-stone-200 bg-white/90 p-6 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]"
            >
                <h2 class="font-display text-2xl text-stone-950">{{ __('frontend.profile.personal_title') }}</h2>
                <p class="mt-2 text-sm leading-7 text-stone-500">{{ __('frontend.profile.personal_description') }}</p>

                <form
                    method="POST"
                    action="{{ route('locale.update') }}"
                    class="mt-6 space-y-3 rounded-2xl border border-stone-200 bg-stone-50 p-4"
                >
                    @csrf

                    <label class="block space-y-2 text-sm font-medium text-stone-700">
                        <span>{{ __('frontend.profile.language') }}</span>
                        <select
                            name="locale"
                            class="w-full rounded-2xl border border-stone-300 bg-white px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900"
                        >
                            <option value="en" @selected(app()->getLocale() === 'en')>
                                {{ __('frontend.profile.languages.en') }}
                            </option>
                            <option value="es" @selected(app()->getLocale() === 'es')>
                                {{ __('frontend.profile.languages.es') }}
                            </option>
                        </select>
                    </label>

                    <button
                        type="submit"
                        class="rounded-full border border-stone-900 px-5 py-3 text-sm font-semibold text-stone-900 transition hover:bg-stone-900 hover:text-amber-50"
                    >
                        {{ __('frontend.profile.update_language') }}
                    </button>
                </form>

                <form method="POST" action="/user/profile-information" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <label class="block space-y-2 text-sm font-medium text-stone-700">
                        <span>{{ __('frontend.profile.name') }}</span>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                        />
                    </label>
                    <x-input-error :messages="$errors->updateProfileInformation->get('name')" />

                    <label class="block space-y-2 text-sm font-medium text-stone-700">
                        <span>{{ __('frontend.profile.email') }}</span>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                        />
                    </label>
                    <x-input-error :messages="$errors->updateProfileInformation->get('email')" />

                    @if (! $user->hasVerifiedEmail())
                        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800">
                            {{ __('frontend.profile.email_unverified') }}
                            <button
                                type="submit"
                                form="resend-verification"
                                class="mt-3 font-semibold underline underline-offset-4"
                            >
                                {{ __('frontend.profile.resend_verification') }}
                            </button>
                        </div>
                    @endif

                    <button
                        type="submit"
                        class="rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
                    >
                        {{ __('frontend.profile.save') }}
                    </button>
                </form>

                @if (! $user->hasVerifiedEmail())
                    <form
                        id="resend-verification"
                        method="POST"
                        action="{{ route('verification.send') }}"
                        class="hidden"
                    >
                        @csrf
                    </form>
                @endif
            </section>

            <section
                class="rounded-[2rem] border border-stone-200 bg-white/90 p-6 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]"
            >
                <h2 class="font-display text-2xl text-stone-950">{{ __('frontend.profile.security_title') }}</h2>
                <p class="mt-2 text-sm leading-7 text-stone-500">{{ __('frontend.profile.security_description') }}</p>

                <form method="POST" action="/user/password" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <label class="block space-y-2 text-sm font-medium text-stone-700">
                        <span>{{ __('frontend.profile.current_password') }}</span>
                        <input
                            type="password"
                            name="current_password"
                            required
                            class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                        />
                    </label>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" />

                    <label class="block space-y-2 text-sm font-medium text-stone-700">
                        <span>{{ __('frontend.profile.new_password') }}</span>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                        />
                    </label>
                    <x-input-error :messages="$errors->updatePassword->get('password')" />

                    <label class="block space-y-2 text-sm font-medium text-stone-700">
                        <span>{{ __('frontend.profile.confirm_password') }}</span>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                        />
                    </label>

                    <button
                        type="submit"
                        class="rounded-full border border-stone-900 px-5 py-3 text-sm font-semibold text-stone-900 transition hover:bg-stone-900 hover:text-amber-50"
                    >
                        {{ __('frontend.profile.update_password') }}
                    </button>
                </form>

                <div class="mt-8 space-y-4 rounded-2xl border border-stone-200 bg-stone-50 p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-semibold text-stone-900">{{ __('frontend.profile.two_factor_title') }}</h3>
                            <p class="mt-1 text-sm text-stone-500">
                                {{ $twoFactorEnabled ? __('frontend.profile.two_factor_enabled') : __('frontend.profile.two_factor_disabled') }}
                            </p>
                        </div>

                        @if ($twoFactorEnabled)
                            <form method="POST" action="/user/two-factor-authentication">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="rounded-full border border-rose-300 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50"
                                >
                                    {{ __('frontend.profile.disable') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="/user/two-factor-authentication">
                                @csrf
                                <button
                                    type="submit"
                                    class="rounded-full bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
                                >
                                    {{ __('frontend.profile.enable') }}
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($twoFactorEnabled && ! $twoFactorConfirmed)
                        <div class="rounded-2xl border border-stone-200 bg-white p-4">
                            <p class="text-sm font-medium text-stone-700">
                                {{ __('frontend.profile.scan_qr') }}
                            </p>
                            <div class="mt-4 inline-flex rounded-2xl bg-stone-900 p-4 text-white">
                                {!! $user->twoFactorQrCodeSvg() !!}
                            </div>
                        </div>
                    @endif

                    @if ($twoFactorEnabled && ! $twoFactorConfirmed)
                        <form method="POST" action="/user/confirmed-two-factor-authentication" class="space-y-3">
                            @csrf
                            <label class="block space-y-2 text-sm font-medium text-stone-700">
                                <span>{{ __('frontend.profile.confirmation_code') }}</span>
                                <input
                                    type="text"
                                    name="code"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                    class="w-full rounded-2xl border border-stone-300 bg-white px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900"
                                />
                            </label>
                            <x-input-error :messages="$errors->get('code')" />
                            <button
                                type="submit"
                                class="rounded-full border border-stone-900 px-4 py-2 text-sm font-semibold text-stone-900 transition hover:bg-stone-900 hover:text-amber-50"
                            >
                                {{ __('frontend.profile.confirm_2fa') }}
                            </button>
                        </form>
                    @endif

                    @if ($twoFactorConfirmed)
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                            <p class="text-sm font-medium text-emerald-800">
                                {{ __('frontend.profile.recovery_codes') }}
                            </p>
                            <div class="mt-3 grid gap-2 md:grid-cols-2">
                                @foreach ($user->recoveryCodes() as $code)
                                    <code class="rounded-xl bg-white px-3 py-2 text-sm text-stone-700">
                                        {{ $code }}
                                    </code>
                                @endforeach
                            </div>

                            <form method="POST" action="/user/two-factor-recovery-codes" class="mt-4">
                                @csrf
                                <button
                                    type="submit"
                                    class="text-sm font-semibold text-emerald-800 underline underline-offset-4"
                                >
                                    {{ __('frontend.profile.regenerate_codes') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </section>
</x-layouts.app>
