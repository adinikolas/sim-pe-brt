<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                Edit Aduan
            </h2>

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900 p-4 text-red-700 dark:text-red-200">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('aduan.update', $aduan->id) }}" method="POST"
                  class="bg-white dark:bg-gray-900 shadow rounded-lg p-6 space-y-4">
                @csrf
                @method('PUT')

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                    <input type="date"
                        name="tanggal"
                        value="{{ old('tanggal', $aduan->tanggal->format('Y-m-d')) }}"
                        required
                        class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                dark:bg-gray-800 dark:text-gray-200">
                </div>

                {{-- Koridor --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Koridor</label>
                    <select name="koridor_id" required
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                   dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">
                        @foreach ($koridors as $koridor)
                            <option value="{{ $koridor->id }}"
                                {{ $aduan->koridor_id == $koridor->id ? 'selected' : '' }}>
                                {{ $koridor->nama_koridor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Aduan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Aduan</label>
                    <select name="jenis_aduan_id" required
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                   dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">
                        @foreach ($jenisAduans as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ $aduan->jenis_aduan_id == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_aduan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Media --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Media Pelaporan</label>
                    <select name="media_pelaporan" required
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                   dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">
                        @foreach (['WA', 'IG', 'Lapor Semar'] as $media)
                            <option value="{{ $media }}"
                                {{ $aduan->media_pelaporan == $media ? 'selected' : '' }}>
                                {{ $media }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Isi Aduan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi Aduan</label>
                    <textarea name="isi_aduan" rows="4" required
                              class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                     dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">{{ old('isi_aduan', $aduan->isi_aduan) }}</textarea>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" required
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                   dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">
                        <option value="Belum" {{ $aduan->status == 'Belum' ? 'selected' : '' }}>Belum</option>
                        <option value="Selesai" {{ $aduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Keterangan Tindak Lanjut
                    </label>
                    <textarea name="keterangan_tindak_lanjut" rows="3"
                              class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                     dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">{{ old('keterangan_tindak_lanjut', $aduan->keterangan_tindak_lanjut) }}</textarea>
                </div>

                {{-- Aksi --}}
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('aduan.index') }}">
                        <x-secondary-button>
                            Batal
                        </x-secondary-button>
                    </a>
                    <x-primary-button type="submit">
                        Update
                    </x-primary-button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
