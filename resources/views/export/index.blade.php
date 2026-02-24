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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">

                    {{-- BULAN --}}
                    <div class="w-full">
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                            Bulan
                        </label>

                        <select
                            x-model="bulan"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                bg-white dark:bg-gray-900
                                text-gray-900 dark:text-gray-100
                                focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Pilih Bulan</option>

                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor

                        </select>
                    </div>


                    {{-- TAHUN --}}
                    <div class="w-full">
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                            Tahun
                        </label>

                        <select
                            x-model="tahun"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                bg-white dark:bg-gray-900
                                text-gray-900 dark:text-gray-100
                                focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Pilih Tahun</option>

                            @for ($y = 2024; $y <= now()->year; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor

                        </select>
                    </div>

                </div>

                {{-- TOMBOL EXPORT --}}
                <div class="mt-8">

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">

                        {{-- EXPORT SESUAI FILTER --}}
                        <a
                            x-bind:href="
                                '{{ route('export.excel') }}'
                                + '?bulan=' + bulan
                                + '&tahun=' + tahun
                            "
                            class="
                                w-full sm:w-auto
                                px-6 py-2.5
                                rounded-lg
                                font-semibold text-sm
                                text-center
                                bg-blue-600 text-white
                                hover:bg-blue-700
                                transition
                                shadow
                            "
                        >
                            Export Sesuai Filter
                        </a>

                        {{-- EXPORT REKAP BULANAN --}}
                        <a
                            x-bind:href="
                                '{{ route('export.rekap.bulanan') }}'
                                + '?bulan=' + bulan
                                + '&tahun=' + tahun
                            "
                            class="
                                w-full sm:w-auto
                                px-6 py-2.5
                                rounded-lg
                                font-semibold text-sm
                                text-center
                                bg-green-600 text-white
                                hover:bg-green-700
                                transition
                                shadow
                            "
                        >
                            Export Rekap Bulanan
                        </a>

                        {{-- EXPORT SEMUA DATA --}}
                        <a
                            href="{{ route('export.excel') }}"
                            class="
                                w-full sm:w-auto
                                px-6 py-2.5
                                rounded-lg
                                font-semibold text-sm
                                text-center
                                bg-gray-600 text-white
                                hover:bg-gray-700
                                transition
                                shadow
                            "
                        >
                            Export Seluruh Data
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
