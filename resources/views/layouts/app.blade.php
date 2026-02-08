<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="
        if(darkMode){
            document.documentElement.classList.add('dark')
        }
    "
    :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('favicon_trans-smg.png') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- MODAL ZOOM GAMBAR --}}
        <div
            x-data="{ open:false, img:'' }"
            x-show="open"
            x-cloak
            x-transition
            :class="open ? 'pointer-events-auto' : 'pointer-events-none'"
            class="fixed inset-0 z-[9999]
                flex items-center justify-center
                bg-black/70"
            @keydown.escape.window="open=false"
            @open-image.window="
                img = $event.detail;
                open = true;
            "
        >
            <img
                :src="img"
                class="max-w-[90%] max-h-[90%]
                    rounded-lg shadow-lg"
            >

            <button
                type="button"
                @click="open=false"
                class="absolute top-6 right-6
                    text-white text-3xl">
                &times;
            </button>
        </div>

        <script>
            window.openImage = function (src) {
                const modal = document.querySelector('[x-data]')
                modal.__x.$data.img = src
                modal.__x.$data.open = true
            }
        </script>
    </body>
</html>
