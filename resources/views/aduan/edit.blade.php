<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Edit Aduan
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-6xl mx-auto px-6 space-y-6">

            {{-- ================= CARD 1 : DATA ADUAN ================= --}}
            <form action="{{ route('aduan.update', $aduan->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                    <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                        Data Aduan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-form.input label="Tanggal"
                                      type="date"
                                      name="tanggal"
                                      value="{{ $aduan->tanggal->format('Y-m-d') }}" />

                        <x-form.input label="Jam"
                                      type="time"
                                      name="jam"
                                      value="{{ old('jam', $aduan->jam) }}" />

                        <x-form.input label="Pelapor"
                                      type="text"
                                      name="pelapor"
                                      value="{{ old('pelapor', $aduan->pelapor) }}" />

                        <x-form.select label="Media Pengaduan"
                                       name="media_pelaporan">
                            @foreach ([
                                'WA','IG','FB','X',
                                'Lapor Semar','Call Center',
                                'Email','Datang Langsung'
                            ] as $media)
                                <option value="{{ $media }}"
                                    {{ $aduan->media_pelaporan==$media?'selected':'' }}>
                                    {{ $media }}
                                </option>
                            @endforeach
                        </x-form.select>

                        <x-form.select label="Koridor"
                                       name="koridor_id">
                            @foreach ($koridors as $k)
                                <option value="{{ $k->id }}"
                                    {{ $aduan->koridor_id==$k->id?'selected':'' }}>
                                    {{ $k->nama_koridor }}
                                </option>
                            @endforeach
                        </x-form.select>

                        <x-form.select label="Jenis Aduan"
                                       name="jenis_aduan_id">
                            @foreach ($jenisAduans as $j)
                                <option value="{{ $j->id }}"
                                    {{ $aduan->jenis_aduan_id==$j->id?'selected':'' }}>
                                    {{ $j->nama_aduan }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="mt-6">
                        <x-form.textarea label="Substansi Pengaduan"
                                         name="isi_aduan"
                                         rows="3">
                            {{ $aduan->isi_aduan }}
                        </x-form.textarea>
                    </div>
                </div>

                <br>

                {{-- ================= CARD 2 : TINDAK LANJUT ================= --}}
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                    <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                        Tindak Lanjut & Operasional
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-form.input label="PTA" name="pta" value="{{ old('pta', $aduan->pta) }}" />
                        <x-form.input label="Pengemudi" name="pengemudi" value="{{ old('pengemudi', $aduan->pengemudi) }}" />
                        <x-form.input label="No Armada" name="no_armada" value="{{ old('no_armada', $aduan->no_armada) }}" />
                        <x-form.input label="TKP" name="tkp" value="{{ old('tkp', $aduan->tkp) }}" />
                    </div>

                    <div class="mt-6">
                        <x-form.textarea label="Keterangan Tindak Lanjut"
                                         name="keterangan_tindak_lanjut"
                                         rows="3">
                            {{ $aduan->keterangan_tindak_lanjut }}
                        </x-form.textarea>
                    </div>

                    <div class="mt-4 w-48">
                        <x-form.select label="Status" name="status">
                            <option value="Belum" {{ $aduan->status=='Belum'?'selected':'' }}>
                                Belum
                            </option>
                            <option value="Selesai" {{ $aduan->status=='Selesai'?'selected':'' }}>
                                Selesai
                            </option>
                        </x-form.select>
                    </div>

                    {{-- AKSI --}}
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t dark:border-gray-700">
                        <a href="{{ route('aduan.index') }}">
                            <x-secondary-button>Batal</x-secondary-button>
                        </a>
                        <x-primary-button>Update</x-primary-button>
                    </div>
                </div>
                <br>

            </form>
        </div>
    </div>
</x-app-layout>
