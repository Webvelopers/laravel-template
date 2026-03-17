@php
    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';
    $headerClass = 'mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-6 lg:px-8';

    if ($isShadcn) {
        $resolvedBodyClass = $bodyClass ?? 'min-h-screen bg-[linear-gradient(180deg,_#f8fafc_0%,_#ffffff_100%)] font-sans text-slate-900';
        $brandClass = 'flex items-center gap-3 text-sm font-medium tracking-[0.18em] text-slate-700 uppercase';
        $brandBadgeClass = 'inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 shadow-sm';
        $navClass = 'flex items-center gap-3 text-sm font-medium text-slate-600';
        $navLinkClass = 'rounded-md px-4 py-2 transition hover:bg-white hover:text-slate-950';
        $primaryNavButtonClass = 'rounded-md bg-slate-950 px-4 py-2 text-white transition hover:bg-slate-800';
    } else {
        $resolvedBodyClass = $bodyClass ?? 'min-h-screen bg-[radial-gradient(circle_at_top,_rgba(217,119,6,0.18),_transparent_32%),linear-gradient(180deg,_#fffdf8_0%,_#fff7ed_100%)] font-sans text-stone-900';
        $brandClass = 'flex items-center gap-3 text-sm font-semibold tracking-[0.24em] text-stone-700 uppercase';
        $brandBadgeClass = 'font-display inline-flex h-10 w-10 items-center justify-center rounded-full bg-stone-900 text-base text-amber-100';
        $navClass = 'flex items-center gap-3 text-sm font-medium text-stone-600';
        $navLinkClass = 'rounded-full px-4 py-2 transition hover:bg-white/70 hover:text-stone-950';
        $primaryNavButtonClass = 'rounded-full bg-stone-900 px-4 py-2 text-amber-50 transition hover:bg-stone-700';
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ $title ?? config('app.name') }}</title>
        <meta name="description" content="{{ __('frontend.meta.description') }}" />
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|dm-sans:400,500,700"
            rel="stylesheet"
        />
        @stack('head')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="{{ $resolvedBodyClass }}">
        <div class="min-h-screen">
            <header class="{{ $headerClass }}">
                <a href="{{ route('home') }}" class="{{ $brandClass }}">
                    <span class="{{ $brandBadgeClass }}">L12</span>
                    <span>{{ config('app.name') }}</span>
                </a>

                <nav class="{{ $navClass }}">
                    <a href="{{ route('home') }}" class="{{ $navLinkClass }}">
                        {{ __('frontend.nav.home') }}
                    </a>
                    <a href="{{ route('templates.index') }}" class="{{ $navLinkClass }}">
                        {{ __('frontend.nav.templates') }}
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="{{ $navLinkClass }}">
                            {{ __('frontend.nav.dashboard') }}
                        </a>
                        <a href="{{ route('profile') }}" class="{{ $navLinkClass }}">
                            {{ __('frontend.nav.profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="{{ $primaryNavButtonClass }}">
                                {{ __('frontend.nav.logout') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="{{ $navLinkClass }}">
                            {{ __('frontend.nav.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="{{ $primaryNavButtonClass }}">
                            {{ __('frontend.nav.register') }}
                        </a>
                    @endauth
                </nav>
            </header>

            <main class="mx-auto w-full max-w-6xl px-6 pb-16 lg:px-8">
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>
