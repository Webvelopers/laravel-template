<section class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
    <div class="space-y-6">
        <p class="text-sm font-semibold tracking-[0.35em] text-amber-700 uppercase">
            {{ __('frontend.welcome.title') }}
        </p>
        <h1 class="font-display max-w-3xl text-5xl leading-tight text-stone-950 md:text-6xl">
            {{ __('frontend.welcome.headline') }}
        </h1>
        <p class="max-w-2xl text-lg leading-8 text-stone-600">{{ __('frontend.welcome.description') }}</p>

        <div class="flex flex-wrap gap-3">
            @auth
                <a
                    href="{{ route('dashboard') }}"
                    class="rounded-full bg-stone-900 px-6 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
                >
                    {{ __('frontend.welcome.open_dashboard') }}
                </a>
            @else
                <a
                    href="{{ route('register') }}"
                    class="rounded-full bg-stone-900 px-6 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700"
                >
                    {{ __('frontend.welcome.create_account') }}
                </a>
                <a
                    href="{{ route('login') }}"
                    class="rounded-full border border-stone-300 bg-white/80 px-6 py-3 text-sm font-semibold text-stone-800 transition hover:border-stone-900"
                >
                    {{ __('frontend.welcome.login') }}
                </a>
            @endauth
            <a
                href="https://laravel.com/docs/12.x"
                target="_blank"
                rel="noreferrer"
                class="rounded-full border border-transparent px-6 py-3 text-sm font-semibold text-stone-700 transition hover:bg-white/70"
            >
                {{ __('frontend.welcome.docs') }}
            </a>
        </div>
    </div>

    <div
        class="rounded-[2rem] border border-stone-200 bg-stone-950 p-8 text-stone-50 shadow-[0_32px_80px_-36px_rgba(120,53,15,0.6)]"
    >
        <p class="text-xs font-semibold tracking-[0.35em] text-amber-300 uppercase">
            {{ __('frontend.welcome.includes') }}
        </p>
        <div class="mt-6 space-y-4">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <h2 class="font-display text-xl">{{ __('frontend.welcome.cards.auth_title') }}</h2>
                <p class="mt-2 text-sm leading-7 text-stone-300">{{ __('frontend.welcome.cards.auth_body') }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <h2 class="font-display text-xl">{{ __('frontend.welcome.cards.dx_title') }}</h2>
                <p class="mt-2 text-sm leading-7 text-stone-300">{{ __('frontend.welcome.cards.dx_body') }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <h2 class="font-display text-xl">{{ __('frontend.welcome.cards.ui_title') }}</h2>
                <p class="mt-2 text-sm leading-7 text-stone-300">{{ __('frontend.welcome.cards.ui_body') }}</p>
            </div>
        </div>
    </div>
</section>
