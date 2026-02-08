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

            {{-- ================= STATISTIK ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                {{-- TOTAL --}}
                <div class="bg-white dark:bg-gray-900
                            border border-gray-200 dark:border-gray-700/60
                            rounded-lg
                            shadow-sm dark:shadow-[0_0_0_1px_rgba(255,255,255,0.05)]
                            p-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Aduan
                    </p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        {{ $totalAduan }}
                    </h3>
                </div>

                {{-- SELESAI --}}
                <div class="bg-white dark:bg-gray-900
                            border border-gray-200 dark:border-gray-700/60
                            rounded-lg
                            shadow-sm dark:shadow-[0_0_0_1px_rgba(255,255,255,0.05)]
                            p-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Aduan Selesai
                    </p>
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">
                        {{ $aduanSelesai }}
                    </h3>
                </div>

                {{-- BELUM --}}
                <div class="bg-white dark:bg-gray-900
                            border border-gray-200 dark:border-gray-700/60
                            rounded-lg
                            shadow-sm dark:shadow-[0_0_0_1px_rgba(255,255,255,0.05)]
                            p-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Belum Ditindaklanjuti
                    </p>
                    <h3 class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                        {{ $aduanBelum }}
                    </h3>
                </div>
            </div>

            {{-- ================= REKAP KORIDOR + GRAFIK ================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                {{-- REKAP PER KORIDOR --}}
                <div class="bg-white dark:bg-gray-900
                            border border-gray-200 dark:border-gray-700/60
                            rounded-lg
                            shadow-sm dark:shadow-[0_0_0_1px_rgba(255,255,255,0.05)]">

                    <div class="border-b border-gray-200 dark:border-gray-700/70 px-4 py-3">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Rekap Aduan per Koridor
                        </h3>
                    </div>

                    <div class="p-4 overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800/70">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium
                                            text-gray-600 dark:text-gray-300 uppercase">
                                        Koridor
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium
                                            text-gray-600 dark:text-gray-300 uppercase">
                                        Total Aduan
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($aduanPerKoridor as $item)
                                    <tr class="border-t border-gray-200 dark:border-gray-700/60">
                                        <td class="px-4 py-2 text-gray-700 dark:text-gray-300">
                                            {{ $item->koridor->nama_koridor }}
                                        </td>
                                        <td class="px-4 py-2 font-semibold
                                                text-gray-800 dark:text-gray-200">
                                            {{ $item->total }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2"
                                            class="px-4 py-4 text-center
                                                text-gray-500 dark:text-gray-400">
                                            Belum ada data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- GRAFIK ADUAN BULANAN --}}
                <div class="bg-white dark:bg-gray-900
                            border border-gray-200 dark:border-gray-700/60
                            rounded-lg
                            shadow-sm dark:shadow-[0_0_0_1px_rgba(255,255,255,0.05)]">

                    <div class="border-b border-gray-200 dark:border-gray-700/70 px-4 py-3">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Grafik Aduan Bulanan
                        </h3>
                    </div>

                    <div class="p-4">
                        <canvas id="aduanBulananChart" height="180"></canvas>
                    </div>
                </div>

            </div>

            {{-- ================= REKAP PER BULAN ================= --}}
            <div class="bg-white dark:bg-gray-900
                        border border-gray-200 dark:border-gray-700/60
                        rounded-lg
                        shadow-sm dark:shadow-[0_0_0_1px_rgba(255,255,255,0.05)]">

                <div class="border-b border-gray-200 dark:border-gray-700/70
                            px-4 py-3">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Rekap Aduan per Bulan
                    </h3>
                </div>

                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-800/70">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium
                                           text-gray-600 dark:text-gray-300 uppercase">
                                    Bulan
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium
                                           text-gray-600 dark:text-gray-300 uppercase">
                                    Total Aduan
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($aduanPerBulan as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{
                                            \Carbon\Carbon::create()
                                                ->month($item->bulan)
                                                ->locale('id')
                                                ->translatedFormat('F')
                                        }}
                                        {{ $item->tahun }}
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('aduanBulananChart').getContext('2d');

        const aduanBulananChart = new Chart(ctx, {
            type: 'bar', // bisa diganti 'line'
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Jumlah Aduan',
                    data: @json($chartData),
                    backgroundColor: 'rgba(79, 70, 229, 0.6)', // indigo
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: document.documentElement.classList.contains('dark')
                                ? '#e5e7eb'
                                : '#374151'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: document.documentElement.classList.contains('dark')
                                ? '#d1d5db'
                                : '#374151'
                        },
                        grid: {
                            color: document.documentElement.classList.contains('dark')
                                ? '#374151'
                                : '#e5e7eb'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: document.documentElement.classList.contains('dark')
                                ? '#d1d5db'
                                : '#374151'
                        },
                        grid: {
                            color: document.documentElement.classList.contains('dark')
                                ? '#374151'
                                : '#e5e7eb'
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>
