@php
    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';
@endphp

<x-layouts.app :title="__('frontend.templates.page_title')">
    <section class="space-y-8">
        <div class="max-w-3xl space-y-3">
            <p
                class="{{ $isShadcn ? 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase' : 'text-sm font-semibold tracking-[0.35em] text-amber-700 uppercase' }}"
            >
                {{ __('frontend.templates.eyebrow') }}
            </p>
            <h1
                class="{{ $isShadcn ? 'text-4xl font-semibold tracking-tight text-slate-950 md:text-5xl' : 'font-display text-4xl text-stone-950 md:text-5xl' }}"
            >
                {{ __('frontend.templates.page_headline') }}
            </h1>
            <p class="{{ $isShadcn ? 'text-base leading-8 text-slate-600' : 'text-base leading-8 text-stone-600' }}">
                {{ __('frontend.templates.page_description') }}
            </p>
        </div>

        @include('templates.options', ['activeTemplate' => $frontendTemplate ?? 'default'])

        <section
            id="shadcn-notes"
            class="{{ $isShadcn ? 'rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_20px_60px_-36px_rgba(15,23,42,0.25)] md:p-8' : 'rounded-[2rem] border border-stone-200 bg-white/80 p-6 md:p-8' }}"
        >
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <h2
                        class="{{ $isShadcn ? 'text-3xl font-semibold tracking-tight text-slate-950' : 'font-display text-3xl text-stone-950' }}"
                    >
                        {{ __('frontend.templates.notes_title') }}
                    </h2>
                    <p
                        class="{{ $isShadcn ? 'mt-3 max-w-2xl text-base leading-8 text-slate-600' : 'mt-3 max-w-2xl text-base leading-8 text-stone-600' }}"
                    >
                        {{ __('frontend.templates.notes_body') }}
                    </p>
                </div>

                <div class="rounded-[1.5rem] border border-slate-200 bg-slate-950 p-5 text-slate-100">
                    <p class="text-xs font-semibold tracking-[0.3em] text-slate-300 uppercase">
                        {{ __('frontend.templates.shadcn_label') }}
                    </p>
                    <p class="mt-3 text-sm leading-7 text-slate-300">{{ __('frontend.templates.notes_sidebar') }}</p>
                </div>
            </div>
        </section>
    </section>
</x-layouts.app>
