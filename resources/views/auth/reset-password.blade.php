<x-layouts.app :title="__('frontend.auth.reset_password.title')">
    <section
        class="mx-auto max-w-xl rounded-[2rem] border border-stone-200 bg-white/90 p-8 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]"
    >
        <p class="text-sm font-semibold tracking-[0.3em] text-amber-700 uppercase">
            {{ __('frontend.auth.reset_password.eyebrow') }}
        </p>
        <h1 class="font-display mt-3 text-4xl text-stone-950">{{ __('frontend.auth.reset_password.headline') }}</h1>

        <form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}" />

            <label class="block space-y-2 text-sm font-medium text-stone-700">
                <span>{{ __('frontend.auth.email') }}</span>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                />
            </label>
            <x-input-error :messages="$errors->get('email')" />

            <label class="block space-y-2 text-sm font-medium text-stone-700">
                <span>{{ __('frontend.auth.password') }}</span>
                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                />
            </label>
            <x-input-error :messages="$errors->get('password')" />

            <label class="block space-y-2 text-sm font-medium text-stone-700">
                <span>{{ __('frontend.auth.reset_password.confirm_password') }}</span>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                />
            </label>

            <button
                type="submit"
                class="rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
            >
                {{ __('frontend.auth.reset_password.submit') }}
            </button>
        </form>
    </section>
</x-layouts.app>
