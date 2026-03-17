<section
    class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_32px_100px_-48px_rgba(15,23,42,0.35)]"
>
    <div
        class="border-b border-slate-200 bg-[linear-gradient(180deg,rgba(248,250,252,0.98),rgba(255,255,255,0.96)),linear-gradient(90deg,rgba(15,23,42,0.06)_1px,transparent_1px),linear-gradient(rgba(15,23,42,0.06)_1px,transparent_1px)] bg-[size:auto,32px_32px,32px_32px] px-6 py-8 md:px-10 md:py-12"
    >
        <div class="max-w-3xl">
            <div
                class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-600 shadow-sm"
            >
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                {{ __('frontend.templates.shadcn_badge') }}
            </div>
            <h2 class="mt-6 max-w-2xl text-4xl font-semibold tracking-tight text-slate-950 md:text-5xl">
                {{ __('frontend.templates.shadcn_headline') }}
            </h2>
            <p class="mt-4 max-w-2xl text-base leading-8 text-slate-600 md:text-lg">
                {{ __('frontend.templates.shadcn_body') }}
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center rounded-md bg-slate-950 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800"
                    >
                        {{ __('frontend.welcome.open_dashboard') }}
                    </a>
                @else
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center justify-center rounded-md bg-slate-950 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800"
                    >
                        {{ __('frontend.welcome.create_account') }}
                    </a>
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-900 transition hover:bg-slate-50"
                    >
                        {{ __('frontend.welcome.login') }}
                    </a>
                @endauth
                <a
                    href="https://ui.shadcn.com"
                    target="_blank"
                    rel="noreferrer"
                    class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    {{ __('frontend.templates.shadcn_docs') }}
                </a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 bg-slate-50 p-6 md:grid-cols-[1.1fr_0.9fr] md:p-10">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        {{ __('frontend.templates.shadcn_metrics_label') }}
                    </p>
                    <h3 class="mt-1 text-2xl font-semibold tracking-tight text-slate-950">
                        {{ __('frontend.templates.shadcn_metrics_title') }}
                    </h3>
                </div>
                <span
                    class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600"
                >
                    {{ __('frontend.templates.shadcn_ship_ready') }}
                </span>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-medium tracking-[0.25em] text-slate-500 uppercase">
                        {{ __('frontend.templates.shadcn_stat_one_label') }}
                    </p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">12</p>
                    <p class="mt-2 text-sm text-slate-600">{{ __('frontend.templates.shadcn_stat_one_copy') }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-medium tracking-[0.25em] text-slate-500 uppercase">
                        {{ __('frontend.templates.shadcn_stat_two_label') }}
                    </p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">3</p>
                    <p class="mt-2 text-sm text-slate-600">{{ __('frontend.templates.shadcn_stat_two_copy') }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-medium tracking-[0.25em] text-slate-500 uppercase">
                        {{ __('frontend.templates.shadcn_stat_three_label') }}
                    </p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">2</p>
                    <p class="mt-2 text-sm text-slate-600">{{ __('frontend.templates.shadcn_stat_three_copy') }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-lg font-semibold tracking-tight text-slate-950">
                        {{ __('frontend.templates.shadcn_panel_title') }}
                    </h3>
                    <span class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                        {{ __('frontend.templates.shadcn_panel_status') }}
                    </span>
                </div>
                <p class="mt-3 text-sm leading-7 text-slate-600">{{ __('frontend.templates.shadcn_panel_body') }}</p>
                <div class="mt-5 space-y-3">
                    <div class="rounded-2xl border border-slate-200 p-4">
                        <p class="text-sm font-medium text-slate-900">
                            {{ __('frontend.templates.shadcn_feature_one_title') }}
                        </p>
                        <p class="mt-1 text-sm leading-6 text-slate-600">
                            {{ __('frontend.templates.shadcn_feature_one_body') }}
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 p-4">
                        <p class="text-sm font-medium text-slate-900">
                            {{ __('frontend.templates.shadcn_feature_two_title') }}
                        </p>
                        <p class="mt-1 text-sm leading-6 text-slate-600">
                            {{ __('frontend.templates.shadcn_feature_two_body') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-950 p-6 text-white shadow-sm">
                <p class="text-sm font-medium text-slate-300">{{ __('frontend.templates.shadcn_terminal_label') }}</p>
                <div
                    class="mt-4 rounded-2xl border border-white/10 bg-white/5 p-4 font-mono text-sm leading-7 text-slate-200"
                >
                    <p>$ composer run dev</p>
                    <p>$ ./vendor/bin/pest tests/Feature/HomeTest.php</p>
                    <p>$ npm run build</p>
                </div>
            </div>
        </div>
    </div>
</section>
