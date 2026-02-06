<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                Form Input Aduan
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

            <form action="{{ route('aduan.store') }}" method="POST"
                  class="bg-white dark:bg-gray-900 shadow rounded-lg p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tanggal Aduan
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        required
                        value="{{ old('tanggal') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700
                            dark:bg-gray-800 dark:text-gray-200
                            focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Koridor</label>
                    <select name="koridor_id" required
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                   dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">
                        <option value="">-- Pilih Koridor --</option>
                        @foreach ($koridors as $koridor)
                            <option value="{{ $koridor->id }}">{{ $koridor->nama_koridor }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Aduan</label>
                    <select name="jenis_aduan_id" required
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                   dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">
                        <option value="">-- Pilih Jenis Aduan --</option>
                        @foreach ($jenisAduans as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_aduan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Media Pelaporan</label>
                    <select name="media_pelaporan" required
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                   dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500">
                        <option value="">-- Pilih Media --</option>
                        <option value="WA">WhatsApp</option>
                        <option value="IG">Instagram</option>
                        <option value="Lapor Semar">Lapor Semar</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi Aduan</label>
                    <textarea name="isi_aduan" rows="4" required
                              class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700
                                     dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('aduan.index') }}"
                       class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700
                              text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">
                        Batal
                    </a>
                    <x-primary-button type="submit">
                        Simpan
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
