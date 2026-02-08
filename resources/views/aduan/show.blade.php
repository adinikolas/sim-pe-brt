<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Detail Aduan
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-6xl mx-auto px-6 space-y-6">

            {{-- ================= CARD : DATA ADUAN ================= --}}
            <div class="card p-6">
                <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                    Data Aduan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Tanggal</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->tanggal->format('d-m-Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Jam</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->jam ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Pelapor</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->pelapor ?? 'Anonim' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Media Pengaduan</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->media_pelaporan }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Koridor</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->koridor->nama_koridor }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Jenis Aduan</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->jenisAduan->nama_aduan }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">
                        Substansi Pengaduan
                    </p>
                    <div class="rounded-md border
                                border-gray-200 dark:border-gray-700
                                p-4 text-gray-900 dark:text-gray-100">
                        {{ $aduan->isi_aduan }}
                    </div>
                </div>
            </div>

            {{-- ================= CARD : LAMPIRAN ================= --}}
            <div class="card p-6">
                <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                    Lampiran Gambar
                </h3>

                @if ($aduan->lampirans->count())
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($aduan->lampirans as $img)
                            <img
                                src="{{ asset('storage/'.$img->file_path) }}"
                                class="h-32 w-full object-cover rounded-md border
                                       dark:border-gray-700 cursor-pointer"
                                @click="$dispatch('open-image', '{{ asset('storage/'.$img->file_path) }}')"
                            >
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tidak ada lampiran gambar.
                    </p>
                @endif
            </div>

            {{-- ================= CARD : TINDAK LANJUT ================= --}}
            <div class="card p-6">
                <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                    Tindak Lanjut & Operasional
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">PTA</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->pta ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Pengemudi</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->pengemudi ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">No Armada</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->no_armada ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">TKP</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $aduan->tkp ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Status</p>
                        @if ($aduan->status === 'Selesai')
                            <span class="inline-block px-2 py-1 text-xs rounded
                                bg-green-100 text-green-700
                                dark:bg-green-900 dark:text-green-300">
                                Selesai
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs rounded
                                bg-yellow-100 text-yellow-700
                                dark:bg-yellow-900 dark:text-yellow-300">
                                Belum
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">
                        Keterangan Tindak Lanjut
                    </p>
                    <div class="rounded-md border
                                border-gray-200 dark:border-gray-700
                                p-4 text-gray-900 dark:text-gray-100">
                        {{ $aduan->keterangan_tindak_lanjut ?? '-' }}
                    </div>
                </div>
            </div>

            {{-- ================= AKSI ================= --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('aduan.index') }}">
                    <x-secondary-button>Kembali</x-secondary-button>
                </a>

                <a href="{{ route('aduan.edit', $aduan->id) }}">
                    <x-primary-button>Edit Aduan</x-primary-button>
                </a>
            </div>
            <br>
        </div>
    </div>
</x-app-layout>
