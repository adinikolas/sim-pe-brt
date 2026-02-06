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
    public function index()
    {
        $aduans = Aduan::with(['koridor', 'jenisAduan'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('aduan.index', compact('aduans'));
    }

    /**
     * Menyimpan data aduan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'koridor_id' => 'required|exists:master_koridors,id',
            'jenis_aduan_id' => 'required|exists:master_jenis_aduans,id',
            'media_pelaporan' => 'required|in:WA,IG,Lapor Semar',
            'isi_aduan' => 'required|string',
            'keterangan_tindak_lanjut' => 'nullable|string',
        ]);

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
            'koridor_id' => 'required|exists:master_koridors,id',
            'jenis_aduan_id' => 'required|exists:master_jenis_aduans,id',
            'media_pelaporan' => 'required|in:WA,IG,Lapor Semar',
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
