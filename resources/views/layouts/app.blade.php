<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data
      :class="{ 'dark': $store.theme.darkMode }"
>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('favicon_trans-smg.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    {{-- PREVENT FLICKER --}}
    <script>
        (function () {

            const theme = localStorage.getItem('theme');

            if (
                theme === 'dark' ||
                (!theme &&
                 window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            }

        })();
    </script>


    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet" />


    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>


<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        {{-- NAVIGATION --}}
        @include('layouts.navigation')


        {{-- HEADER --}}
        @if (isset($header))

            <header class="bg-white dark:bg-gray-800 shadow">

                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

                    {{ $header }}

                </div>

            </header>

        @endif


        {{-- CONTENT --}}
        <main>

            {{ $slot }}

        </main>


    </div>



    {{-- MODAL IMAGE ZOOM --}}
    <div
        x-data="{ open:false, img:'' }"
        x-show="open"
        x-cloak
        x-transition
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
                   text-white text-3xl"
        >
            &times;
        </button>

    </div>



    {{-- IMAGE HELPER --}}
    <script>

        window.openImage = function (src) {

            window.dispatchEvent(
                new CustomEvent('open-image', {
                    detail: src
                })
            );

        };

    </script>



    {{-- GLOBAL THEME HANDLER --}}
    <script>

    document.addEventListener('alpine:init', () => {

        Alpine.store('theme', {

            theme: localStorage.getItem('theme') ?? 'system',

            darkMode: false,

            init() {

                this.apply();

                window.matchMedia('(prefers-color-scheme: dark)')
                    .addEventListener('change', () => {

                        if (this.theme === 'system') {
                            this.apply();
                        }

                    });

            },

            set(mode) {

                this.theme = mode;

                if (mode === 'system') {

                    localStorage.removeItem('theme');

                } else {

                    localStorage.setItem('theme', mode);

                }

                this.apply();

            },

            apply() {

                if (this.theme === 'dark') {

                    this.darkMode = true;

                }
                else if (this.theme === 'light') {

                    this.darkMode = false;

                }
                else {

                    this.darkMode =
                        window.matchMedia('(prefers-color-scheme: dark)').matches;

                }

                document.documentElement.classList.toggle(
                    'dark',
                    this.darkMode
                );

            }

        });

        Alpine.store('theme').init();

    });
    </script>

</body>
</html>
