<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Master Jenis Aduan
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-5xl mx-auto px-6 space-y-6">

            {{-- ================= TAMBAH JENIS ADUAN ================= --}}
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    Tambah Jenis Aduan
                </h3>

                <form action="{{ route('jenis-aduan.store') }}" method="POST"
                      class="flex gap-3">
                    @csrf

                    <input
                        type="text"
                        name="nama_aduan"
                        placeholder="Contoh: AC Tidak Dingin"
                        class="flex-1 rounded-md
                            bg-white dark:bg-gray-800
                            text-gray-900 dark:text-gray-100
                            border border-gray-300 dark:border-gray-600
                            focus:ring focus:ring-indigo-500/30"
                        required
                    >

                    <button
                        type="submit"
                        class="px-5 py-2 rounded-md
                            bg-black text-white
                            dark:bg-white dark:text-black
                            font-medium">
                        Simpan
                    </button>
                </form>
            </div>

            {{-- ================= TABEL JENIS ADUAN ================= --}}
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">No</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">
                                Nama Jenis Aduan
                            </th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($jenisAduans as $j)
                        <tr class="border-t dark:border-gray-700">

                            {{-- FORM UPDATE (1 ROW = 1 FORM) --}}
                            <form action="{{ route('jenis-aduan.update', $j->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- NO --}}
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- NAMA --}}
                                <td class="px-4 py-3">
                                    <input
                                        type="text"
                                        name="nama_aduan"
                                        value="{{ $j->nama_aduan }}"
                                        class="w-full rounded-md
                                            bg-white dark:bg-gray-800
                                            text-gray-900 dark:text-gray-100
                                            border border-gray-300 dark:border-gray-600"
                                        required
                                    >
                                </td>

                                {{-- AKSI --}}
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-2">

                                        {{-- UPDATE --}}
                                        <button
                                            type="submit"
                                            class="px-4 py-1.5 rounded-md
                                                bg-indigo-600 text-white
                                                hover:bg-indigo-700">
                                            Update
                                        </button>
                            </form>

                                        {{-- STATUS / HAPUS --}}
                                        @if ($j->aduans_count > 0)
                                            <span
                                                class="inline-flex items-center px-4 py-1.5 rounded-md
                                                    text-xs font-medium
                                                    bg-yellow-100 text-yellow-800
                                                    dark:bg-yellow-900 dark:text-yellow-200">
                                                Dipakai ({{ $j->aduans_count }})
                                            </span>
                                        @else
                                            <form action="{{ route('jenis-aduan.destroy', $j->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Hapus jenis aduan ini?')"
                                                    class="px-4 py-1.5 rounded-md
                                                        bg-red-600 text-white
                                                        hover:bg-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                        </tr>
                        @endforeach

                        @if ($jenisAduans->isEmpty())
                        <tr>
                            <td colspan="3"
                                class="px-4 py-6 text-center text-gray-500">
                                Data jenis aduan belum tersedia
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </div>

</x-app-layout>
