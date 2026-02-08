<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Edit Aduan
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-6xl mx-auto px-6 space-y-6">

            {{-- =====================================================
                FORM UPDATE ADUAN (SATU-SATUNYA FORM UPDATE)
            ====================================================== --}}
            <form action="{{ route('aduan.update', $aduan->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ===== CARD : DATA ADUAN ===== --}}
                <div class="card p-6">
                    <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                        Data Aduan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-form.input label="Tanggal" type="date"
                                      name="tanggal"
                                      value="{{ $aduan->tanggal->format('Y-m-d') }}" />

                        <x-form.input label="Jam" type="time"
                                      name="jam"
                                      value="{{ old('jam', $aduan->jam) }}" />

                        <x-form.input label="Pelapor"
                                      name="pelapor"
                                      value="{{ old('pelapor', $aduan->pelapor) }}" />

                        <x-form.select label="Media Pengaduan" name="media_pelaporan">
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

                        <x-form.select label="Koridor" name="koridor_id">
                            @foreach ($koridors as $k)
                                <option value="{{ $k->id }}"
                                    {{ $aduan->koridor_id==$k->id?'selected':'' }}>
                                    {{ $k->nama_koridor }}
                                </option>
                            @endforeach
                        </x-form.select>

                        <x-form.select label="Jenis Aduan" name="jenis_aduan_id">
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

                    {{-- ===== INPUT TAMBAH LAMPIRAN ===== --}}
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tambah Lampiran Gambar
                        </label>

                        <input
                            type="file"
                            name="lampirans[]"
                            multiple
                            accept="image/*"
                            class="block w-full text-sm
                                text-gray-900 dark:text-gray-100
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md
                                file:border-0
                                file:bg-gray-200 file:text-gray-700
                                dark:file:bg-gray-700 dark:file:text-gray-200">
                    </div>
                </div>

                <br>

                {{-- ===== CARD : TINDAK LANJUT ===== --}}
                <div class="card p-6">
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
            </form>

            {{-- =====================================================
                LAMPIRAN SAAT INI (DI LUAR FORM UPDATE)
            ====================================================== --}}
            @if ($aduan->lampirans->count())
            <div class="card p-6">
                <h3 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                    Lampiran Saat Ini
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($aduan->lampirans as $img)
                    <div class="relative group">
                        <img
                            src="{{ asset('storage/'.$img->file_path) }}"
                            class="h-28 w-full object-cover rounded-md border
                                   dark:border-gray-700 cursor-pointer"
                            @click="$dispatch('open-image', '{{ asset('storage/'.$img->file_path) }}')"
                        >

                        {{-- FORM HAPUS LAMPIRAN (AMAN) --}}
                        <form action="{{ route('aduan.lampiran.destroy', $img->id) }}"
                              method="POST"
                              class="absolute top-1 right-1"
                              onsubmit="return confirm('Hapus gambar ini?')">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="bg-red-600 text-white text-xs
                                       rounded-full w-6 h-6
                                       opacity-0 group-hover:opacity-100
                                       transition">
                                ✕
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <br>
        </div>
    </div>
</x-app-layout>
