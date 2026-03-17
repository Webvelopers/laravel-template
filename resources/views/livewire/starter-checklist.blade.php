@php
    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';

    if ($isShadcn) {
        $sectionClass = 'rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_20px_60px_-36px_rgba(15,23,42,0.25)]';
        $eyebrowClass = 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase';
        $titleClass = 'mt-2 text-2xl font-semibold tracking-tight text-slate-950';
        $chipClass = 'rounded-full bg-slate-100 px-4 py-2 text-xs font-medium tracking-[0.2em] text-slate-700 uppercase';
        $readyCardClass = 'rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4';
        $reviewCardClass = 'rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4';
        $readyBadgeClass = 'rounded-full bg-emerald-200 px-3 py-1 text-xs font-medium tracking-[0.16em] text-emerald-800 uppercase';
        $reviewBadgeClass = 'rounded-full bg-amber-200 px-3 py-1 text-xs font-medium tracking-[0.16em] text-amber-800 uppercase';
        $labelClass = 'font-medium text-slate-900';
        $valueClass = 'mt-2 text-sm text-slate-600';
    } else {
        $sectionClass = 'rounded-[2rem] border border-stone-200 bg-white/90 p-6 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]';
        $eyebrowClass = 'text-xs font-semibold tracking-[0.3em] text-amber-700 uppercase';
        $titleClass = 'font-display mt-2 text-2xl text-stone-950';
        $chipClass = 'rounded-full bg-emerald-100 px-4 py-2 text-xs font-semibold tracking-[0.24em] text-emerald-700 uppercase';
        $readyCardClass = 'rounded-2xl border border-emerald-200 bg-emerald-50/70 px-4 py-4';
        $reviewCardClass = 'rounded-2xl border border-amber-200 bg-amber-50/70 px-4 py-4';
        $readyBadgeClass = 'rounded-full bg-emerald-200 px-3 py-1 text-xs font-semibold tracking-[0.2em] text-emerald-800 uppercase';
        $reviewBadgeClass = 'rounded-full bg-amber-200 px-3 py-1 text-xs font-semibold tracking-[0.2em] text-amber-800 uppercase';
        $labelClass = 'font-medium text-stone-900';
        $valueClass = 'mt-2 text-sm text-stone-600';
    }
@endphp

<section class="{{ $sectionClass }}">
    <div class="flex items-center justify-between gap-4">
        <div>
            <p class="{{ $eyebrowClass }}">
                {{ __('frontend.checklist.eyebrow') }}
            </p>
            <h2 class="{{ $titleClass }}">{{ __('frontend.checklist.headline') }}</h2>
        </div>
        <span class="{{ $chipClass }}">Livewire</span>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2">
        @foreach ($checks as $check)
            <div class="{{ $check['ready'] ? $readyCardClass : $reviewCardClass }}">
                <div class="flex items-center justify-between gap-3">
                    <p class="{{ $labelClass }}">{{ $check['label'] }}</p>
                    <span class="{{ $check['ready'] ? $readyBadgeClass : $reviewBadgeClass }}">
                        {{ $check['ready'] ? __('frontend.checklist.ok') : __('frontend.checklist.review') }}
                    </span>
                </div>
                <p class="{{ $valueClass }}">{{ $check['value'] }}</p>
            </div>
        @endforeach
    </div>
</section>
