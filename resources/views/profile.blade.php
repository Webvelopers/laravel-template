@php
    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';
    $supportedLocales = config('frontend.locales.supported', []);
    $supportedTemplates = config('frontend.templates.supported', []);
    $defaultTemplate = config('frontend.templates.default', 'default');
    $pageTitleClass = $isShadcn ? 'text-4xl font-semibold tracking-tight text-slate-950' : 'font-display text-4xl text-stone-950';
    $eyebrowClass = $isShadcn ? 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase' : 'text-sm font-semibold tracking-[0.35em] text-amber-700 uppercase';
    $bodyCopyClass = $isShadcn ? 'max-w-2xl text-base leading-8 text-slate-600' : 'max-w-2xl text-base leading-8 text-stone-600';
    $sectionCardClass = $isShadcn ? 'rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_20px_60px_-36px_rgba(15,23,42,0.25)]' : 'rounded-[2rem] border border-stone-200 bg-white/90 p-6 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]';
    $subtleCardClass = $isShadcn ? 'rounded-2xl border border-slate-200 bg-slate-50 p-4' : 'rounded-2xl border border-stone-200 bg-stone-50 p-4';
    $subtlePanelClass = $isShadcn ? 'mt-8 space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-5' : 'mt-8 space-y-4 rounded-2xl border border-stone-200 bg-stone-50 p-5';
    $fieldLabelClass = $isShadcn ? 'block space-y-2 text-sm font-medium text-slate-700' : 'block space-y-2 text-sm font-medium text-stone-700';
    $sectionTitleClass = $isShadcn ? 'text-2xl font-semibold tracking-tight text-slate-950' : 'font-display text-2xl text-stone-950';
    $sectionDescriptionClass = $isShadcn ? 'mt-2 text-sm leading-7 text-slate-500' : 'mt-2 text-sm leading-7 text-stone-500';
    $warningCardClass = $isShadcn ? 'rounded-xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800' : 'rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800';
    $twoFactorTitleClass = $isShadcn ? 'font-medium text-slate-900' : 'font-semibold text-stone-900';
    $twoFactorBodyClass = $isShadcn ? 'mt-1 text-sm text-slate-500' : 'mt-1 text-sm text-stone-500';
    $twoFactorCardClass = $isShadcn ? 'rounded-2xl border border-slate-200 bg-white p-4' : 'rounded-2xl border border-stone-200 bg-white p-4';
    $twoFactorCardTitleClass = $isShadcn ? 'text-sm font-medium text-slate-700' : 'text-sm font-medium text-stone-700';
    $qrWrapClass = $isShadcn ? 'mt-4 inline-flex rounded-xl bg-slate-950 p-4 text-white' : 'mt-4 inline-flex rounded-2xl bg-stone-900 p-4 text-white';
    $twoFactorEnableButtonClass = $isShadcn ? 'rounded-md bg-slate-950 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800' : 'rounded-full bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50 transition hover:bg-stone-700';
    $recoveryCodeClass = $isShadcn ? 'rounded-md bg-white px-3 py-2 text-sm text-slate-700' : 'rounded-xl bg-white px-3 py-2 text-sm text-stone-700';
    $recoveryActionClass = $isShadcn ? 'text-sm font-medium text-emerald-800 underline underline-offset-4' : 'text-sm font-semibold text-emerald-800 underline underline-offset-4';
    $inputClass = $isShadcn ? 'w-full rounded-md border border-slate-300 bg-white px-4 py-3 text-slate-900 transition outline-none focus:border-slate-950 focus:ring-2 focus:ring-slate-950/10' : 'w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white';
    $primaryButtonClass = $isShadcn ? 'rounded-md bg-slate-950 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800' : 'rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700';
    $secondaryButtonClass = $isShadcn ? 'rounded-md border border-slate-300 px-5 py-3 text-sm font-medium text-slate-900 transition hover:bg-slate-50' : 'rounded-full border border-stone-900 px-5 py-3 text-sm font-semibold text-stone-900 transition hover:bg-stone-900 hover:text-amber-50';
    $dangerButtonClass = $isShadcn ? 'rounded-md border border-rose-200 px-4 py-2 text-sm font-medium text-rose-700 transition hover:bg-rose-50' : 'rounded-full border border-rose-300 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50';
@endphp

<x-layouts.app :title="__('frontend.profile.title')">
    @php
        $user = auth()->user();
        $role = $currentUserRole ?? \App\Enums\UserRole::User;
        $roleBadgeClass = $isShadcn ? 'inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium tracking-[0.2em] text-slate-600 uppercase' : 'inline-flex rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold tracking-[0.24em] text-amber-700 uppercase';
        $twoFactorEnabled = $user->two_factor_secret !== null;
        $twoFactorConfirmed = $user->two_factor_confirmed_at !== null;
    @endphp

    <section class="space-y-8">
        <div class="space-y-2">
            <p class="{{ $eyebrowClass }}">
                {{ __('frontend.profile.title') }}
            </p>
            <h1 class="{{ $pageTitleClass }}">{{ __('frontend.profile.headline') }}</h1>
            <p class="{{ $bodyCopyClass }}">{{ __('frontend.profile.description') }}</p>
            <p class="{{ $roleBadgeClass }}">
                {{ __('frontend.roles.label') }}: {{ __('frontend.roles.' . $role->value) }}
            </p>
        </div>

        <x-status-banner :status="session('status')" />

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="{{ $sectionCardClass }}">
                <h2 class="{{ $sectionTitleClass }}">{{ __('frontend.profile.personal_title') }}</h2>
                <p class="{{ $sectionDescriptionClass }}">{{ __('frontend.profile.personal_description') }}</p>

                <form
                    method="POST"
                    action="{{ route('locale.update') }}"
                    class="{{ $subtleCardClass }} mt-6 space-y-3"
                >
                    @csrf

                    <label class="{{ $fieldLabelClass }}">
                        <span>{{ __('frontend.profile.language') }}</span>
                        <select name="locale" class="{{ $inputClass }}">
                            @foreach ($supportedLocales as $locale)
                                <option value="{{ $locale }}" @selected(app()->getLocale() === $locale)>
                                    {{ __('frontend.profile.languages.' . $locale) }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <button type="submit" class="{{ $secondaryButtonClass }}">
                        {{ __('frontend.profile.update_language') }}
                    </button>
                </form>

                <form
                    method="POST"
                    action="{{ route('frontend-template.update') }}"
                    class="{{ $subtleCardClass }} mt-6 space-y-3"
                >
                    @csrf

                    <label class="{{ $fieldLabelClass }}">
                        <span>{{ __('frontend.profile.template') }}</span>
                        <select name="frontend_template" class="{{ $inputClass }}">
                            @foreach ($supportedTemplates as $template)
                                <option
                                    value="{{ $template }}"
                                    @selected(($frontendTemplate ?? $defaultTemplate) === $template)
                                >
                                    {{ __('frontend.profile.templates.' . $template) }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <p
                        class="{{ $isShadcn ? 'text-sm leading-7 text-slate-500' : 'text-sm leading-7 text-stone-500' }}"
                    >
                        {{ __('frontend.profile.template_description') }}
                    </p>

                    <button type="submit" class="{{ $primaryButtonClass }}">
                        {{ __('frontend.profile.update_template') }}
                    </button>
                </form>

                @if ($role->isAdmin())
                    <div class="{{ $subtleCardClass }} mt-6 space-y-3">
                        <p class="{{ $fieldLabelClass }}">{{ __('frontend.profile.admin_tools') }}</p>
                        <p
                            class="{{ $isShadcn ? 'text-sm leading-7 text-slate-500' : 'text-sm leading-7 text-stone-500' }}"
                        >
                            {{ __('frontend.profile.admin_tools_description') }}
                        </p>
                        <a href="{{ route('admin.settings') }}" class="{{ $secondaryButtonClass }} inline-flex">
                            {{ __('frontend.profile.open_admin_settings') }}
                        </a>
                    </div>
                @endif

                <form method="POST" action="{{ route('user-profile-information.update') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <label class="{{ $fieldLabelClass }}">
                        <span>{{ __('frontend.profile.name') }}</span>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="{{ $inputClass }}"
                        />
                    </label>
                    <x-input-error :messages="$errors->updateProfileInformation->get('name')" />

                    <label class="{{ $fieldLabelClass }}">
                        <span>{{ __('frontend.profile.email') }}</span>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="{{ $inputClass }}"
                        />
                    </label>
                    <x-input-error :messages="$errors->updateProfileInformation->get('email')" />

                    @if (! $user->hasVerifiedEmail())
                        <div class="{{ $warningCardClass }}">
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

                    <button type="submit" class="{{ $primaryButtonClass }}">
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

            <section class="{{ $sectionCardClass }}">
                <h2 class="{{ $sectionTitleClass }}">{{ __('frontend.profile.security_title') }}</h2>
                <p class="{{ $sectionDescriptionClass }}">{{ __('frontend.profile.security_description') }}</p>

                <form method="POST" action="{{ route('user-password.update') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <label class="{{ $fieldLabelClass }}">
                        <span>{{ __('frontend.profile.current_password') }}</span>
                        <input type="password" name="current_password" required class="{{ $inputClass }}" />
                    </label>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" />

                    <label class="{{ $fieldLabelClass }}">
                        <span>{{ __('frontend.profile.new_password') }}</span>
                        <input type="password" name="password" required class="{{ $inputClass }}" />
                    </label>
                    <x-input-error :messages="$errors->updatePassword->get('password')" />

                    <label class="{{ $fieldLabelClass }}">
                        <span>{{ __('frontend.profile.confirm_password') }}</span>
                        <input type="password" name="password_confirmation" required class="{{ $inputClass }}" />
                    </label>

                    <button type="submit" class="{{ $secondaryButtonClass }}">
                        {{ __('frontend.profile.update_password') }}
                    </button>
                </form>

                <div class="{{ $subtlePanelClass }}">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="{{ $twoFactorTitleClass }}">{{ __('frontend.profile.two_factor_title') }}</h3>
                            <p class="{{ $twoFactorBodyClass }}">
                                {{ $twoFactorEnabled ? __('frontend.profile.two_factor_enabled') : __('frontend.profile.two_factor_disabled') }}
                            </p>
                        </div>

                        @if ($twoFactorEnabled)
                            <form method="POST" action="{{ route('two-factor.disable') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ $dangerButtonClass }}">
                                    {{ __('frontend.profile.disable') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('two-factor.enable') }}">
                                @csrf
                                <button type="submit" class="{{ $twoFactorEnableButtonClass }}">
                                    {{ __('frontend.profile.enable') }}
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($twoFactorEnabled && ! $twoFactorConfirmed)
                        <div class="{{ $twoFactorCardClass }}">
                            <p class="{{ $twoFactorCardTitleClass }}">{{ __('frontend.profile.scan_qr') }}</p>
                            <div class="{{ $qrWrapClass }}">
                                {!! $user->twoFactorQrCodeSvg() !!}
                            </div>
                        </div>
                    @endif

                    @if ($twoFactorEnabled && ! $twoFactorConfirmed)
                        <form method="POST" action="{{ route('two-factor.confirm') }}" class="space-y-3">
                            @csrf
                            <label class="{{ $fieldLabelClass }}">
                                <span>{{ __('frontend.profile.confirmation_code') }}</span>
                                <input
                                    type="text"
                                    name="code"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                    class="{{ $inputClass }}"
                                />
                            </label>
                            <x-input-error :messages="$errors->get('code')" />
                            <button type="submit" class="{{ $secondaryButtonClass }}">
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
                                    <code class="{{ $recoveryCodeClass }}">
                                        {{ $code }}
                                    </code>
                                @endforeach
                            </div>

                            <form
                                method="POST"
                                action="{{ route('two-factor.regenerate-recovery-codes') }}"
                                class="mt-4"
                            >
                                @csrf
                                <button type="submit" class="{{ $recoveryActionClass }}">
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
