<x-layouts.app :title="__('frontend.auth.verify_email.title')">
    <section
        class="mx-auto max-w-xl rounded-[2rem] border border-stone-200 bg-white/90 p-8 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]"
    >
        <p class="text-sm font-semibold tracking-[0.3em] text-amber-700 uppercase">
            {{ __('frontend.auth.verify_email.eyebrow') }}
        </p>
        <h1 class="font-display mt-3 text-4xl text-stone-950">{{ __('frontend.auth.verify_email.headline') }}</h1>
        <p class="mt-3 text-base leading-7 text-stone-600">{{ __('frontend.auth.verify_email.description') }}</p>

        <div class="mt-8 space-y-4">
            <x-auth-session-status
                :status="session('status') === 'verification-link-sent' ? __('frontend.auth.verify_email.resent') : null"
            />

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button
                    type="submit"
                    class="rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
                >
                    {{ __('frontend.auth.verify_email.submit') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-semibold text-stone-700 underline underline-offset-4">
                    {{ __('frontend.auth.verify_email.logout') }}
                </button>
            </form>
        </div>
    </section>
</x-layouts.app>
