<x-layouts.app :title="__('frontend.auth.two_factor.title')">
    <section
        class="mx-auto max-w-xl rounded-[2rem] border border-stone-200 bg-white/90 p-8 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]"
    >
        <p class="text-sm font-semibold tracking-[0.3em] text-amber-700 uppercase">
            {{ __('frontend.auth.two_factor.eyebrow') }}
        </p>
        <h1 class="font-display mt-3 text-4xl text-stone-950">{{ __('frontend.auth.two_factor.headline') }}</h1>
        <p class="mt-3 text-base leading-7 text-stone-600">{{ __('frontend.auth.two_factor.description') }}</p>

        <form method="POST" action="{{ route('two-factor.login.store') }}" class="mt-8 space-y-4">
            @csrf

            <label class="block space-y-2 text-sm font-medium text-stone-700">
                <span>{{ __('frontend.auth.two_factor.code') }}</span>
                <input
                    type="text"
                    name="code"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                />
            </label>
            <x-input-error :messages="$errors->get('code')" />

            <label class="block space-y-2 text-sm font-medium text-stone-700">
                <span>{{ __('frontend.auth.two_factor.recovery_code') }}</span>
                <input
                    type="text"
                    name="recovery_code"
                    class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                />
            </label>
            <x-input-error :messages="$errors->get('recovery_code')" />

            <button
                type="submit"
                class="rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
            >
                {{ __('frontend.auth.two_factor.submit') }}
            </button>
        </form>
    </section>
</x-layouts.app>
