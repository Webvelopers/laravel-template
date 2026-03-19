@php
    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';

    if ($isShadcn) {
        $heroClass = 'rounded-[1.75rem] border border-slate-200 bg-white p-8 shadow-[0_20px_60px_-36px_rgba(15,23,42,0.25)]';
        $eyebrowClass = 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase';
        $titleClass = 'mt-3 text-4xl font-semibold tracking-tight text-slate-950';
        $copyClass = 'mt-4 max-w-2xl text-base leading-8 text-slate-600';
        $primaryButtonClass = 'rounded-md bg-slate-950 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800';
        $secondaryButtonClass = 'rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50';
    } else {
        $heroClass = 'rounded-[2rem] border border-stone-200 bg-white/80 p-8 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]';
        $eyebrowClass = 'text-sm font-semibold tracking-[0.35em] text-amber-700 uppercase';
        $titleClass = 'font-display mt-3 text-4xl text-stone-950';
        $copyClass = 'mt-4 max-w-2xl text-base leading-8 text-stone-600';
        $primaryButtonClass = 'rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700';
        $secondaryButtonClass = 'rounded-full border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-700 transition hover:border-stone-900';
    }

    $user = auth()->user();
    $role = $currentUserRole ?? \App\Enums\UserRole::User;
    $roleBadgeClass = $isShadcn ? 'mt-4 inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium tracking-[0.2em] text-slate-600 uppercase' : 'mt-4 inline-flex rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold tracking-[0.24em] text-amber-700 uppercase';
@endphp

<x-layouts.app :title="__('frontend.dashboard.eyebrow')">
    <section class="space-y-8">
        <div class="{{ $heroClass }}">
            <p class="{{ $eyebrowClass }}">
                {{ __('frontend.dashboard.eyebrow') }}
            </p>
            <h1 class="{{ $titleClass }}">
                {{ __('frontend.dashboard.greeting', ['name' => $user->name]) }}
            </h1>
            <p class="{{ $copyClass }}">{{ __('frontend.dashboard.description') }}</p>
            <p class="{{ $roleBadgeClass }}">
                {{ __('frontend.roles.label') }}: {{ __('frontend.roles.' . $role->value) }}
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('profile') }}" class="{{ $primaryButtonClass }}">
                    {{ __('frontend.dashboard.manage_profile') }}
                </a>
                @if ($role->isAdmin())
                    <a href="{{ route('admin.settings') }}" class="{{ $secondaryButtonClass }}">
                        {{ __('frontend.dashboard.admin_settings') }}
                    </a>
                @endif

                <a
                    href="https://laravel.com/docs/12.x"
                    target="_blank"
                    rel="noreferrer"
                    class="{{ $secondaryButtonClass }}"
                >
                    {{ __('frontend.dashboard.docs') }}
                </a>
            </div>
        </div>

        <livewire:starter-checklist />
    </section>
</x-layouts.app>
