<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Requestify') }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:500,600,700|ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="grid min-h-screen lg:grid-cols-[minmax(0,5fr)_minmax(0,6fr)]">
            {{-- Brand side: the hex mark, large, cropped by the edge --}}
            <aside class="relative hidden overflow-hidden bg-navy text-white lg:flex lg:flex-col lg:justify-between lg:p-12">
                <img src="{{ asset('favicon.svg') }}" alt="" aria-hidden="true"
                     class="pointer-events-none absolute -right-40 top-1/2 w-[34rem] -translate-y-1/2 opacity-[0.16]">
                <a href="{{ url('/') }}" class="relative flex items-center gap-3">
                    <img src="{{ asset('favicon.svg') }}" alt="" class="h-10 w-10">
                    <span class="font-display text-xl font-semibold">Requestify</span>
                </a>
                <div class="relative max-w-sm">
                    <p class="font-display text-[2rem] font-semibold leading-tight">
                        {{ __('Ask HR once. Know exactly where it stands.') }}
                    </p>
                    <p class="mt-4 text-[0.95rem] leading-relaxed text-slate-300">
                        {{ __('Leave, remote work, documents, equipment and evaluations: sent, reviewed and answered in one place, with an email at every decision.') }}
                    </p>
                </div>
                <p class="relative text-sm text-slate-400">{{ __('Built by Mehdi Aichouch') }}</p>
            </aside>

            <main class="flex items-center justify-center bg-white px-6 py-12">
                <div class="w-full max-w-sm">
                    <a href="{{ url('/') }}" class="mb-10 flex items-center gap-3 lg:hidden">
                        <img src="{{ asset('favicon.svg') }}" alt="" class="h-9 w-9">
                        <span class="font-display text-lg font-semibold text-ink">Requestify</span>
                    </a>
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
