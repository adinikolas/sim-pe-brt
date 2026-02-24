<nav x-data="{ open: false, themeOpen: false }"
    class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo
                            class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('aduan.index')" :active="request()->routeIs('aduan.*')">
                        Daftar Aduan
                    </x-nav-link>

                    <x-nav-link :href="route('koridor.index')" :active="request()->routeIs('koridor.*')">
                        Koridor
                    </x-nav-link>

                    <x-nav-link :href="route('jenis-aduan.index')" :active="request()->routeIs('jenis-aduan.*')">
                        Jenis Aduan
                    </x-nav-link>

                    <x-nav-link :href="route('export.index')" :active="request()->routeIs('export.*')">
                        Export
                    </x-nav-link>

                </div>

            </div>


            <!-- RIGHT -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                {{-- THEME SWITCHER --}}
                <div class="relative mr-4" x-data="{ open:false }">

                    {{-- BUTTON (ICON ONLY) --}}
                    <button
                        @click="open=!open"
                        class="p-2 rounded-lg
                            bg-gray-200 dark:bg-gray-700
                            hover:bg-gray-300 dark:hover:bg-gray-600
                            text-gray-800 dark:text-gray-200
                            transition"
                        title="Theme"
                    >

                        {{-- LIGHT ICON (SUN) --}}
                        <svg x-show="$store.theme.theme==='light'"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="w-5 h-5">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3v2.25M12 18.75V21M4.5 12H3m18 0h-1.5M6.343
                                    6.343l-1.59-1.59m12.374
                                    12.374l1.59 1.59M6.343
                                    17.657l-1.59 1.59m12.374-12.374l1.59-1.59M12
                                    7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
                        </svg>


                        {{-- DARK ICON (MOON) --}}
                        <svg x-show="$store.theme.theme==='dark'"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="w-5 h-5">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.752 15.002A9.718 9.718 0 0112
                                    21c-5.385 0-9.75-4.365-9.75-9.75
                                    0-3.906 2.29-7.277 5.602-8.82a.75.75
                                    0 01.98.98A7.5 7.5 0 0019.5
                                    14.25a.75.75 0 01.98.752z"/>
                        </svg>


                        {{-- SYSTEM ICON (COMPUTER DESKTOP) --}}
                        <svg x-show="$store.theme.theme==='system'"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="w-5 h-5">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 6.75A2.25 2.25 0 015.25
                                    4.5h13.5A2.25 2.25 0 0121
                                    6.75v8.25A2.25 2.25 0 0118.75
                                    17.25H5.25A2.25 2.25 0 013
                                    15V6.75z"/>

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 20.25h7.5"/>
                        </svg>

                    </button>



                    {{-- DROPDOWN --}}
                    <div x-show="open"
                        @click.outside="open=false"
                        x-transition
                        class="absolute right-0 mt-2 w-44
                                bg-white dark:bg-gray-800
                                text-gray-800 dark:text-gray-200
                                border border-gray-200 dark:border-gray-700
                                rounded-lg shadow-lg z-50">


                        {{-- LIGHT --}}
                        <button
                            @click="$store.theme.set('light'); open=false"
                            class="flex items-center gap-2 w-full px-4 py-2
                                hover:bg-gray-100 dark:hover:bg-gray-700"
                            :class="$store.theme.theme==='light'
                                    ? 'text-blue-600 font-semibold'
                                    : ''"
                        >

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="w-5 h-5">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v2.25M12 18.75V21M4.5 12H3m18
                                        0h-1.5M6.343
                                        6.343l-1.59-1.59m12.374
                                        12.374l1.59 1.59M6.343
                                        17.657l-1.59 1.59m12.374-12.374l1.59-1.59M12
                                        7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
                            </svg>

                            Light

                        </button>


                        {{-- DARK --}}
                        <button
                            @click="$store.theme.set('dark'); open=false"
                            class="flex items-center gap-2 w-full px-4 py-2
                                hover:bg-gray-100 dark:hover:bg-gray-700"
                            :class="$store.theme.theme==='dark'
                                    ? 'text-blue-600 font-semibold'
                                    : ''"
                        >

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="w-5 h-5">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21.752 15.002A9.718 9.718 0 0112
                                        21c-5.385 0-9.75-4.365-9.75-9.75
                                        0-3.906 2.29-7.277 5.602-8.82a.75.75
                                        0 01.98.98A7.5 7.5 0 0019.5
                                        14.25a.75.75 0 01.98.752z"/>
                            </svg>

                            Dark

                        </button>


                        {{-- SYSTEM --}}
                        <button
                            @click="$store.theme.set('system'); open=false"
                            class="flex items-center gap-2 w-full px-4 py-2
                                hover:bg-gray-100 dark:hover:bg-gray-700"
                            :class="$store.theme.theme==='system'
                                    ? 'text-blue-600 font-semibold'
                                    : ''"
                        >

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="w-5 h-5">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 6.75A2.25 2.25 0 015.25
                                        4.5h13.5A2.25 2.25 0 0121
                                        6.75v8.25A2.25 2.25 0 0118.75
                                        17.25H5.25A2.25 2.25 0 013
                                        15V6.75z"/>

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8.25 20.25h7.5"/>
                            </svg>

                            System

                        </button>

                    </div>

                </div>

                <!-- USER DROPDOWN -->
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button
                            class="inline-flex items-center px-3 py-2
                                   border border-transparent
                                   text-sm font-medium rounded-md
                                   text-gray-500 dark:text-gray-400
                                   bg-white dark:bg-gray-800
                                   hover:text-gray-700 dark:hover:text-gray-300
                                   focus:outline-none transition"
                        >

                            {{ Auth::user()->name }}

                            <svg class="ml-1 h-4 w-4 fill-current"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"/>
                            </svg>

                        </button>

                    </x-slot>


                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                         this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">

                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2
                           rounded-md text-gray-400
                           hover:text-gray-500 hover:bg-gray-100
                           focus:outline-none transition">

                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">

                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>

                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>

                    </svg>

                </button>

            </div>

        </div>

    </div>

</nav>
