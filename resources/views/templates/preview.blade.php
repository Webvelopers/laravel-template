@php
    $templateName = match ($template) {
        'default' => __('frontend.templates.default_name'),
        'shadcn' => __('frontend.templates.shadcn_name'),
    };

    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';
@endphp

<x-layouts.app :title="__('frontend.templates.preview_title', ['template' => $templateName])">
    <section class="space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div class="space-y-2">
                <p
                    class="{{ $isShadcn ? 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase' : 'text-sm font-semibold tracking-[0.35em] text-amber-700 uppercase' }}"
                >
                    {{ __('frontend.templates.preview_eyebrow') }}
                </p>
                <h1
                    class="{{ $isShadcn ? 'text-4xl font-semibold tracking-tight text-slate-950 md:text-5xl' : 'font-display text-4xl text-stone-950 md:text-5xl' }}"
                >
                    {{ $templateName }}
                </h1>
                <p
                    class="{{ $isShadcn ? 'max-w-2xl text-base leading-8 text-slate-600' : 'max-w-2xl text-base leading-8 text-stone-600' }}"
                >
                    {{ __('frontend.templates.preview_description') }}
                </p>
            </div>

            <a
                href="{{ route('templates.index') }}"
                class="{{ $isShadcn ? 'inline-flex rounded-md border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50' : 'inline-flex rounded-full border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 transition hover:border-stone-900 hover:bg-white' }}"
            >
                {{ __('frontend.templates.back_to_options') }}
            </a>
        </div>

        @include('templates.options', ['activeTemplate' => $frontendTemplate ?? 'default'])

        @include('templates.' . $template)
    </section>
</x-layouts.app>
