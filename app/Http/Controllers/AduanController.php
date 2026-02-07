<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Koridor;
use App\Models\JenisAduan;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    /**
     * Menampilkan daftar aduan
     */
    public function index(Request $request)
    {
        $query = Aduan::with(['koridor','jenisAduan'])
            ->orderBy('tanggal', 'desc');

        // FILTER BULAN & TAHUN
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // SEARCH
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('pelapor', 'like', "%$q%")
                    ->orWhere('media_pelaporan', 'like', "%$q%")
                    ->orWhere('no_armada', 'like', "%$q%")
                    ->orWhereHas('koridor', function ($k) use ($q) {
                        $k->where('nama_koridor', 'like', "%$q%");
                    })
                    ->orWhereHas('jenisAduan', function ($j) use ($q) {
                        $j->where('nama_aduan', 'like', "%$q%");
                    });
            });
        }

        $aduans = $query->get();

        return view('aduan.index', compact('aduans'));
    }

    /**
     * Menyimpan data aduan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'nullable',
            'pelapor' => 'nullable|string|max:100',
            'pta' => 'nullable|string|max:100',
            'pengemudi' => 'nullable|string|max:100',
            'no_armada' => 'nullable|string|max:50',
            'tkp' => 'nullable|string|max:150',

            'koridor_id' => 'required|exists:master_koridors,id',
            'jenis_aduan_id' => 'required|exists:master_jenis_aduans,id',
            'media_pelaporan' => 'required|in:WA,IG,FB,X,Lapor Semar,Call Center,Email,Datang Langsung',

            'isi_aduan' => 'required|string',
            'keterangan_tindak_lanjut' => 'nullable|string',
        ]);

        // Default status saat input
        $validated['status'] = 'Belum';

        Aduan::create($validated);

        return redirect()
            ->route('aduan.index')
            ->with('success', 'Data aduan berhasil disimpan');
    }

    /**
     * Menampilkan detail satu aduan
     */
    public function show($id)
    {
        $aduan = Aduan::with(['koridor', 'jenisAduan'])->findOrFail($id);

        return response()->json($aduan);
    }

    /**
     * Update data aduan
     */
    public function update(Request $request, $id)
    {
        $aduan = Aduan::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'nullable',
            'pelapor' => 'nullable|string|max:100',
            'pta' => 'nullable|string|max:100',
            'pengemudi' => 'nullable|string|max:100',
            'no_armada' => 'nullable|string|max:50',
            'tkp' => 'nullable|string|max:150',

            'koridor_id' => 'required|exists:master_koridors,id',
            'jenis_aduan_id' => 'required|exists:master_jenis_aduans,id',
            'media_pelaporan' => 'required|in:WA,IG,FB,X,Lapor Semar,Call Center,Email,Datang Langsung',

            'isi_aduan' => 'required|string',
            'status' => 'required|in:Selesai,Belum',
            'keterangan_tindak_lanjut' => 'nullable|string',
        ]);

        $aduan->update($validated);

        return redirect()
            ->route('aduan.index')
            ->with('success', 'Data aduan berhasil diperbarui');
    }

    /**
     * Hapus data aduan
     */
    public function destroy($id)
    {
        $aduan = Aduan::findOrFail($id);
        $aduan->delete();

        return response()->json([
            'message' => 'Data aduan berhasil dihapus'
        ]);
    }

    public function create()
    {
        $koridors = Koridor::all();
        $jenisAduans = JenisAduan::all();

        return view('aduan.create', compact('koridors', 'jenisAduans'));
    }

    public function edit($id)
    {
        $aduan = Aduan::findOrFail($id);
        $koridors = Koridor::all();
        $jenisAduans = JenisAduan::all();

        return view('aduan.edit', compact('aduan', 'koridors', 'jenisAduans'));
    }

}
