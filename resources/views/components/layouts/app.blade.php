<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $title ?? config('app.name') }}</title>
        <meta name="description" content="{{ __('frontend.meta.description') }}" />
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|dm-sans:400,500,700"
            rel="stylesheet"
        />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body
        class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(217,119,6,0.18),_transparent_32%),linear-gradient(180deg,_#fffdf8_0%,_#fff7ed_100%)] font-sans text-stone-900"
    >
        <div class="min-h-screen">
            <header class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-6 lg:px-8">
                <a
                    href="{{ route('home') }}"
                    class="flex items-center gap-3 text-sm font-semibold tracking-[0.24em] text-stone-700 uppercase"
                >
                    <span
                        class="font-display inline-flex h-10 w-10 items-center justify-center rounded-full bg-stone-900 text-base text-amber-100"
                    >
                        L12
                    </span>
                    <span>{{ config('app.name') }}</span>
                </a>

                <nav class="flex items-center gap-3 text-sm font-medium text-stone-600">
                    <a
                        href="{{ route('home') }}"
                        class="rounded-full px-4 py-2 transition hover:bg-white/70 hover:text-stone-950"
                    >
                        {{ __('frontend.nav.home') }}
                    </a>

                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="rounded-full px-4 py-2 transition hover:bg-white/70 hover:text-stone-950"
                        >
                            {{ __('frontend.nav.dashboard') }}
                        </a>
                        <a
                            href="{{ route('profile') }}"
                            class="rounded-full px-4 py-2 transition hover:bg-white/70 hover:text-stone-950"
                        >
                            {{ __('frontend.nav.profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="rounded-full bg-stone-900 px-4 py-2 text-amber-50 transition hover:bg-stone-700"
                            >
                                {{ __('frontend.nav.logout') }}
                            </button>
                        </form>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-full px-4 py-2 transition hover:bg-white/70 hover:text-stone-950"
                        >
                            {{ __('frontend.nav.login') }}
                        </a>
                        <a
                            href="{{ route('register') }}"
                            class="rounded-full bg-stone-900 px-4 py-2 text-amber-50 transition hover:bg-stone-700"
                        >
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
