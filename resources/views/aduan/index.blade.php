<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Daftar Aduan
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto px-6 space-y-6">

            <div class="flex items-center justify-between gap-12">

                {{-- KIRI: FILTER BULAN & TAHUN --}}
                <form method="GET"
                    id="filterForm"
                    class="flex items-center gap-x-5">

                    <select name="bulan"
                        class="h-10 min-w-[150px]
                            rounded-md border border-gray-300 dark:border-gray-600
                            bg-white dark:bg-gray-800
                            text-gray-900 dark:text-gray-100
                            hover:border-gray-400 dark:hover:border-gray-500
                            focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                            font-medium transition-colors"
                        onchange="submitFilter()">
                        <option value="">Semua Bulan</option>
                        @for ($i=1; $i<=12; $i++)
                            <option value="{{ $i }}"
                                {{ request('bulan')==$i?'selected':'' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    <select name="tahun"
                        class="h-10 min-w-[150px]
                            rounded-md border border-gray-300 dark:border-gray-600
                            bg-white dark:bg-gray-800
                            text-gray-900 dark:text-gray-100
                            hover:border-gray-400 dark:hover:border-gray-500
                            focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                            font-medium transition-colors"
                        onchange="submitFilter()">
                        <option value="">Semua Tahun</option>
                        @for ($y=2024; $y<=now()->year; $y++)
                            <option value="{{ $y }}"
                                {{ request('tahun')==$y?'selected':'' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>

                    {{-- RESET --}}
                    <button type="button"
                        onclick="window.location.href='{{ route('aduan.index') }}'"
                        class="h-10 inline-flex items-center justify-center px-5
                            rounded-md border-2 border-gray-300 dark:border-gray-600
                            bg-white dark:bg-gray-800
                            text-gray-700 dark:text-gray-200
                            hover:bg-gray-100 dark:hover:bg-gray-700
                            hover:border-gray-400 dark:hover:border-gray-500
                            font-medium transition-colors">
                        Reset
                    </button>
                </form>

                {{-- KANAN: SEARCH + TAMBAH --}}
                <div class="flex items-center gap-x-8">

                    {{-- SEARCH --}}
                    <input type="text"
                        name="q"
                        form="filterForm"
                        value="{{ request('q') }}"
                        placeholder="Cari aduan..."
                        class="h-10 min-w-[260px]
                            rounded-md border border-gray-300 dark:border-gray-600
                            bg-white dark:bg-gray-800
                            text-gray-900 dark:text-gray-100
                            placeholder-gray-400 dark:placeholder-gray-500
                            hover:border-gray-400 dark:hover:border-gray-500
                            focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                            transition-colors"
                        onkeyup="debounceSubmit()">

                    {{-- TAMBAH --}}
                    <a href="{{ route('aduan.create') }}">
                        <x-primary-button class="h-10 whitespace-nowrap">
                            + Tambah Aduan
                        </x-primary-button>
                    </a>
                </div>
            </div>

            {{-- ================= TABEL (CARD SETARA CREATE/EDIT) ================= --}}
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Jam</th>
                                <th class="px-4 py-3">Pelapor</th>
                                <th class="px-4 py-3">Koridor</th>
                                <th class="px-4 py-3">Jenis Aduan</th>
                                <th class="px-4 py-3">Media</th>
                                <th class="px-4 py-3">No Armada</th>
                                <th class="px-4 py-3">TKP</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($aduans as $aduan)
                                <tr class="border-t dark:border-gray-700">
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $aduan->tanggal->format('d-m-Y') }}</td>
                                    <td class="px-4 py-3">{{ $aduan->jam ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $aduan->pelapor ?? 'Anonim' }}</td>
                                    <td class="px-4 py-3">{{ $aduan->koridor->nama_koridor }}</td>
                                    <td class="px-4 py-3">{{ $aduan->jenisAduan->nama_aduan }}</td>
                                    <td class="px-4 py-3">{{ $aduan->media_pelaporan }}</td>
                                    <td class="px-4 py-3">{{ $aduan->no_armada ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $aduan->tkp ?? '-' }}</td>

                                    {{-- STATUS --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($aduan->status === 'Selesai')
                                            <span class="px-2 py-1 rounded text-xs
                                                bg-green-100 text-green-700
                                                dark:bg-green-900 dark:text-green-300">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded text-xs
                                                bg-yellow-100 text-yellow-700
                                                dark:bg-yellow-900 dark:text-yellow-300">
                                                Belum
                                            </span>
                                        @endif
                                    </td>

                                    {{-- AKSI (TOMBOL SEJAJAR) --}}
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('aduan.edit', $aduan->id) }}"
                                               class="inline-flex items-center px-3 py-1.5
                                                      rounded-md text-xs font-medium
                                                      bg-indigo-100 text-indigo-700
                                                      dark:bg-indigo-900 dark:text-indigo-300
                                                      hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                                Edit
                                            </a>

                                            <form action="{{ route('aduan.destroy', $aduan->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Hapus data ini?')"
                                                    class="inline-flex items-center px-3 py-1.5
                                                           rounded-md text-xs font-medium
                                                           bg-red-100 text-red-700
                                                           dark:bg-red-900 dark:text-red-300
                                                           hover:bg-red-200 dark:hover:bg-red-800">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11"
                                        class="px-4 py-6 text-center text-gray-500">
                                        Data aduan tidak tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        let timer;

        function submitFilter() {
            document.getElementById('filterForm').submit();
        }

        function debounceSubmit() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                submitFilter();
            }, 500); // delay 0.5 detik saat mengetik
        }
    </script>

</x-app-layout>
