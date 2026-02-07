<x-app-layout>

    {{-- HEADER (POSISI SAMA DENGAN DAFTAR ADUAN) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Tambah Aduan
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-6xl mx-auto px-6 space-y-6">

            <form action="{{ route('aduan.store') }}" method="POST"
                  class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                @csrf

                {{-- ================= DATA ADUAN ================= --}}
                <div>
                    <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                        Data Aduan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form.input
                            label="Tanggal"
                            type="date"
                            name="tanggal"
                            required
                            value="{{ old('tanggal', now()->format('Y-m-d')) }}" />

                        <x-form.input
                            label="Jam"
                            type="time"
                            name="jam"
                            value="{{ old('jam') }}" />

                        <x-form.input
                            label="Pelapor"
                            name="pelapor"
                            value="{{ old('pelapor', 'Anonim') }}" />

                        <x-form.select
                            label="Media Pengaduan"
                            name="media_pelaporan"
                            required>
                            @foreach ([
                                'WA','IG','FB','X',
                                'Lapor Semar','Call Center',
                                'Email','Datang Langsung'
                            ] as $media)
                                <option value="{{ $media }}">{{ $media }}</option>
                            @endforeach
                        </x-form.select>

                        <x-form.select
                            label="Koridor"
                            name="koridor_id"
                            required>
                            @foreach ($koridors as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_koridor }}</option>
                            @endforeach
                        </x-form.select>

                        <x-form.select
                            label="Jenis Aduan"
                            name="jenis_aduan_id"
                            required>
                            @foreach ($jenisAduans as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_aduan }}</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="mt-6">
                        <x-form.textarea
                            label="Substansi Pengaduan"
                            name="isi_aduan"
                            rows="4"
                            required>
                            {{ old('isi_aduan') }}
                        </x-form.textarea>
                    </div>
                </div>

                {{-- ================= AKSI ================= --}}
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t dark:border-gray-700">
                    <a href="{{ route('aduan.index') }}">
                        <x-secondary-button>Batal</x-secondary-button>
                    </a>
                    <x-primary-button>Simpan</x-primary-button>
                </div>

            </form>
            <br>
        </div>
    </div>
</x-app-layout>
