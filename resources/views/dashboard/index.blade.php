<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Dashboard Aduan
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Ringkasan data aduan dan saran operasional
                </p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-900 shadow rounded-lg p-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Aduan</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        {{ $totalAduan }}
                    </h3>
                </div>

                <div class="bg-white dark:bg-gray-900 shadow rounded-lg p-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Aduan Selesai</p>
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">
                        {{ $aduanSelesai }}
                    </h3>
                </div>

                <div class="bg-white dark:bg-gray-900 shadow rounded-lg p-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum Ditindaklanjuti</p>
                    <h3 class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                        {{ $aduanBelum }}
                    </h3>
                </div>
            </div>

            {{-- Rekap Per Koridor --}}
            <div class="bg-white dark:bg-gray-900 shadow rounded-lg mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Rekap Aduan per Koridor
                    </h3>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Koridor
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Total Aduan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($aduanPerKoridor as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $item->koridor->nama_koridor }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $item->total }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2"
                                        class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Rekap Per Bulan --}}
            <div class="bg-white dark:bg-gray-900 shadow rounded-lg">
                <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Rekap Aduan per Bulan
                    </h3>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Bulan
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Total Aduan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($aduanPerBulan as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                        Bulan {{ $item->bulan }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $item->total }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2"
                                        class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
