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
                    tahun: '',
                    koridor: ''
                }"
                class="bg-white dark:bg-gray-800 rounded-xl shadow p-6"
            >

                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-6">
                    Pengaturan Export Data
                </h3>

                {{-- FILTER --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

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

                    {{-- KORIDOR --}}
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                            Koridor
                        </label>
                        <select
                            x-model="koridor"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600
                                bg-white dark:bg-gray-900
                                text-gray-900 dark:text-gray-100"
                        >
                            <option value="">Semua Koridor</option>
                            @foreach($koridors as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_koridor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- TOMBOL --}}
                <div class="mt-6 flex flex-wrap gap-4">

                    {{-- EXPORT SESUAI FILTER --}}
                    <a
                        x-bind:href="
                            '{{ route('export.excel') }}'
                            + '?bulan=' + bulan
                            + '&tahun=' + tahun
                            + '&koridor=' + koridor
                        "
                        class="
                            h-11 px-6 rounded-lg font-semibold text-sm
                            inline-flex items-center justify-center
                            bg-white text-black dark:bg-white dark:text-black
                            border border-white
                            hover:bg-gray-200
                            transition
                        "
                    >
                        Export Sesuai Filter
                    </a>

                    {{-- EXPORT REKAP BULANAN --}}
                    <a
                    x-bind:href="
                    '{{ route('export.rekap.bulanan') }}'
                    +'?bulan='+bulan
                    +'&tahun='+tahun
                    +'&koridor='+koridor
                    "
                    class="
                    h-11 px-6 rounded-lg font-semibold text-sm
                    inline-flex items-center justify-center
                    bg-green-600 text-white
                    hover:bg-green-700
                    transition
                    "
                    >
                    Export Rekap Bulanan
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
