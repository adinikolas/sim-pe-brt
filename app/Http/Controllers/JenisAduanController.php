<?php

namespace App\Http\Controllers;

use App\Models\JenisAduan;
use Illuminate\Http\Request;

class JenisAduanController extends Controller
{
    public function index()
    {
        $jenisAduans = JenisAduan::withCount('aduans')
            ->orderBy('nama_aduan')
            ->get();

        return view('master.jenis-aduan.index', compact('jenisAduans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_aduan' => 'required|string|max:150'
        ]);

        JenisAduan::create($request->only('nama_aduan'));

        return back()->with('success', 'Jenis aduan berhasil ditambahkan');
    }

    public function update(Request $request, JenisAduan $jenisAduan)
    {
        $request->validate([
            'nama_aduan' => 'required|string|max:150'
        ]);

        $jenisAduan->update($request->only('nama_aduan'));

        return back()->with('success', 'Jenis aduan berhasil diperbarui');
    }

    public function destroy(JenisAduan $jenisAduan)
    {
        // BLOK JIKA MASIH DIPAKAI
        if ($jenisAduan->aduans()->exists()) {
            return back()->with(
                'error',
                'Jenis aduan tidak bisa dihapus karena masih digunakan pada data aduan.'
            );
        }

        $jenisAduan->delete();

        return back()->with('success', 'Jenis aduan berhasil dihapus');
    }
}
