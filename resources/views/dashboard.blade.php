<x-layouts.app :title="__('frontend.dashboard.eyebrow')">
    <section class="space-y-8">
        <div
            class="rounded-[2rem] border border-stone-200 bg-white/80 p-8 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]"
        >
            <p class="text-sm font-semibold tracking-[0.35em] text-amber-700 uppercase">
                {{ __('frontend.dashboard.eyebrow') }}
            </p>
            <h1 class="font-display mt-3 text-4xl text-stone-950">
                {{ __('frontend.dashboard.greeting', ['name' => auth()->user()->name]) }}
            </h1>
            <p class="mt-4 max-w-2xl text-base leading-8 text-stone-600">{{ __('frontend.dashboard.description') }}</p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a
                    href="{{ route('profile') }}"
                    class="rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
                >
                    {{ __('frontend.dashboard.manage_profile') }}
                </a>
                <a
                    href="https://laravel.com/docs/12.x"
                    target="_blank"
                    rel="noreferrer"
                    class="rounded-full border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-700 transition hover:border-stone-900"
                >
                    {{ __('frontend.dashboard.docs') }}
                </a>
            </div>
        </div>

        <livewire:starter-checklist />
    </section>
</x-layouts.app>
