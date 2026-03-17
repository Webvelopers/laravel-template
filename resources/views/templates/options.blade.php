@props([
    'activeTemplate' => null,
])

@php
    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';

    if ($isShadcn) {
        $sectionClass = 'rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_20px_60px_-36px_rgba(15,23,42,0.25)] md:p-8';
        $eyebrowClass = 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase';
        $titleClass = 'text-3xl font-semibold tracking-tight text-slate-950 md:text-4xl';
        $copyClass = 'text-base leading-7 text-slate-600';
        $browseButtonClass = 'inline-flex rounded-md border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50';
        $defaultCardClass = 'rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5';
        $defaultLabelClass = 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase';
        $defaultTitleClass = 'mt-2 text-2xl font-semibold tracking-tight text-slate-950';
        $defaultDescriptionClass = 'mt-3 text-sm leading-7 text-slate-600';
        $defaultPreviewClass = 'mt-5 rounded-[1.25rem] border border-slate-200 bg-white p-4';
        $defaultIconClass = 'inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 shadow-sm';
        $defaultPreviewTitleClass = 'text-sm font-medium text-slate-900';
        $defaultPreviewCopyClass = 'text-xs text-slate-500';
        $defaultUseClass = 'rounded-md bg-slate-950 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800';
        $defaultPreviewButtonClass = 'rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-white';
        $defaultBadgeClass = 'rounded-full bg-slate-950 px-3 py-1 text-xs font-medium text-white';
    } else {
        $sectionClass = 'rounded-[2rem] border border-stone-200 bg-white/85 p-6 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.35)] md:p-8';
        $eyebrowClass = 'text-xs font-semibold tracking-[0.35em] text-amber-700 uppercase';
        $titleClass = 'font-display text-3xl text-stone-950 md:text-4xl';
        $copyClass = 'text-base leading-7 text-stone-600';
        $browseButtonClass = 'inline-flex rounded-full border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 transition hover:border-stone-900 hover:bg-white';
        $defaultCardClass = 'rounded-[1.75rem] border border-stone-200 bg-stone-50 p-5';
        $defaultLabelClass = 'text-xs font-semibold tracking-[0.3em] text-amber-700 uppercase';
        $defaultTitleClass = 'font-display mt-2 text-2xl text-stone-950';
        $defaultDescriptionClass = 'mt-3 text-sm leading-7 text-stone-600';
        $defaultPreviewClass = 'mt-5 rounded-[1.5rem] border border-stone-200 bg-white p-4';
        $defaultIconClass = 'font-display inline-flex h-10 w-10 items-center justify-center rounded-full bg-stone-900 text-amber-100';
        $defaultPreviewTitleClass = 'text-sm font-semibold text-stone-900';
        $defaultPreviewCopyClass = 'text-xs text-stone-500';
        $defaultUseClass = 'rounded-full bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50 transition hover:bg-stone-700';
        $defaultPreviewButtonClass = 'rounded-full border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700 transition hover:border-stone-900 hover:bg-white';
        $defaultBadgeClass = 'rounded-full bg-stone-900 px-3 py-1 text-xs font-semibold text-amber-50';
    }
@endphp

<section class="{{ $sectionClass }}">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div class="max-w-2xl space-y-2">
            <p class="{{ $eyebrowClass }}">
                {{ __('frontend.templates.eyebrow') }}
            </p>
            <h2 class="{{ $titleClass }}">
                {{ __('frontend.templates.headline') }}
            </h2>
            <p class="{{ $copyClass }}">{{ __('frontend.templates.description') }}</p>
        </div>

        <a href="{{ route('templates.index') }}" class="{{ $browseButtonClass }}">
            {{ __('frontend.templates.view_all') }}
        </a>
    </div>

    <div class="mt-8 grid gap-5 lg:grid-cols-2">
        <article class="{{ $defaultCardClass }}">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="{{ $defaultLabelClass }}">
                        {{ __('frontend.templates.default_label') }}
                    </p>
                    <h3 class="{{ $defaultTitleClass }}">
                        {{ __('frontend.templates.default_name') }}
                    </h3>
                </div>

                @if ($activeTemplate === 'default')
                    <span class="{{ $defaultBadgeClass }}">
                        {{ __('frontend.templates.current') }}
                    </span>
                @endif
            </div>

            <p class="{{ $defaultDescriptionClass }}">
                {{ __('frontend.templates.default_description') }}
            </p>

            <div class="{{ $defaultPreviewClass }}">
                <div class="flex items-center gap-3">
                    <span class="{{ $defaultIconClass }}">L12</span>
                    <div>
                        <p class="{{ $defaultPreviewTitleClass }}">
                            {{ __('frontend.templates.default_preview_title') }}
                        </p>
                        <p class="{{ $defaultPreviewCopyClass }}">
                            {{ __('frontend.templates.default_preview_copy') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('home') }}" class="{{ $defaultUseClass }}">
                    {{ __('frontend.templates.use_default') }}
                </a>
                <a href="{{ route('templates.show', 'default') }}" class="{{ $defaultPreviewButtonClass }}">
                    {{ __('frontend.templates.preview') }}
                </a>
            </div>
        </article>

        <article class="rounded-[1.75rem] border border-slate-200 bg-slate-950 p-5 text-slate-50">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold tracking-[0.3em] text-slate-300 uppercase">
                        {{ __('frontend.templates.shadcn_label') }}
                    </p>
                    <h3 class="mt-2 text-2xl font-semibold tracking-tight text-white">
                        {{ __('frontend.templates.shadcn_name') }}
                    </h3>
                </div>

                @if ($activeTemplate === 'shadcn')
                    <span
                        class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-white"
                    >
                        {{ __('frontend.templates.current') }}
                    </span>
                @endif
            </div>

            <p class="mt-3 text-sm leading-7 text-slate-300">{{ __('frontend.templates.shadcn_description') }}</p>

            <div class="mt-5 rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex h-10 items-center rounded-full border border-white/10 px-4 text-sm font-medium text-white"
                    >
                        {{ __('frontend.templates.shadcn_chip') }}
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-white">
                            {{ __('frontend.templates.shadcn_preview_title') }}
                        </p>
                        <p class="text-xs text-slate-400">{{ __('frontend.templates.shadcn_preview_copy') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                <a
                    href="{{ route('templates.show', 'shadcn') }}"
                    class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-slate-100"
                >
                    {{ __('frontend.templates.preview') }}
                </a>
                <a
                    href="{{ route('templates.index') }}#shadcn-notes"
                    class="rounded-full border border-white/15 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:bg-white/5"
                >
                    {{ __('frontend.templates.details') }}
                </a>
            </div>
        </article>
    </div>
</section>
