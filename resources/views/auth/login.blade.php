<x-layouts.app :title="__('frontend.auth.login.title')">
    <section
        class="mx-auto max-w-xl rounded-[2rem] border border-stone-200 bg-white/90 p-8 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]"
    >
        <p class="text-sm font-semibold tracking-[0.3em] text-amber-700 uppercase">
            {{ __('frontend.auth.login.eyebrow') }}
        </p>
        <h1 class="font-display mt-3 text-4xl text-stone-950">{{ __('frontend.auth.login.headline') }}</h1>
        <p class="mt-3 text-base leading-7 text-stone-600">{{ __('frontend.auth.login.description') }}</p>

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-4">
            @csrf

            <x-auth-session-status :status="session('status')" />

            <label class="block space-y-2 text-sm font-medium text-stone-700">
                <span>{{ __('frontend.auth.email') }}</span>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
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
                    autocomplete="current-password"
                    class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white"
                />
            </label>
            <x-input-error :messages="$errors->get('password')" />

            <label class="flex items-center gap-3 text-sm text-stone-600">
                <input
                    type="checkbox"
                    name="remember"
                    class="rounded border-stone-300 text-stone-900 focus:ring-stone-900"
                />
                <span>{{ __('frontend.auth.remember') }}</span>
            </label>

            <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                <a
                    href="{{ route('password.request') }}"
                    class="text-sm font-semibold text-stone-700 underline underline-offset-4"
                >
                    {{ __('frontend.auth.login.forgot') }}
                </a>
                <button
                    type="submit"
                    class="rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
                >
                    {{ __('frontend.auth.login.submit') }}
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
