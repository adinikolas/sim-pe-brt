<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Export Data Aduan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6">

            <div
                x-data="{
                    bulan: '',
                    tahun: ''
                }"
                class="bg-white dark:bg-gray-800 rounded-xl shadow p-6"
            >

                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-6">
                    Pengaturan Export Data
                </h3>

                {{-- FILTER --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- BULAN --}}
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                            Bulan
                        </label>
                        <select
                            x-model="bulan"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600
                                bg-white dark:bg-gray-900
                                text-gray-900 dark:text-gray-100"
                        >
                            <option value="">Semua Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- TAHUN --}}
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                            Tahun
                        </label>
                        <select
                            x-model="tahun"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600
                                bg-white dark:bg-gray-900
                                text-gray-900 dark:text-gray-100"
                        >
                            <option value="">Semua Tahun</option>
                            @for ($y = 2024; $y <= now()->year; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                </div>

                {{-- TOMBOL --}}
                <div class="mt-6 flex flex-wrap gap-4">

                    {{-- EXPORT SESUAI FILTER --}}
                    <a
                        x-bind:href="bulan && tahun
                            ? '{{ route('export.excel') }}?bulan=' + bulan + '&tahun=' + tahun
                            : '#'"
                        x-bind:class="bulan && tahun
                            ? 'bg-white text-black dark:bg-white dark:text-black'
                            : 'bg-gray-400 text-gray-600 cursor-not-allowed'"
                        class="
                            h-11 px-6 rounded-lg font-semibold text-sm
                            inline-flex items-center justify-center
                            border border-white
                            transition
                        "
                    >
                        Export Sesuai Filter
                    </a>

                    {{-- EXPORT SEMUA --}}
                    <a
                        href="{{ route('export.excel') }}"
                        class="
                            h-11 px-6 rounded-lg font-semibold text-sm
                            inline-flex items-center justify-center
                            bg-black text-white
                            dark:bg-white dark:text-black
                            border border-black dark:border-white
                            hover:bg-gray-800 dark:hover:bg-gray-200
                            transition
                        "
                    >
                        Export Seluruh Data
                    </a>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
