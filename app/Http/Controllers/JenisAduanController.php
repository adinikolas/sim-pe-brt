<?php

namespace App\Http\Controllers;

use App\Models\JenisAduan;
use Illuminate\Http\Request;

class JenisAduanController extends Controller
{
    public function index()
    {
        $jenisAduans = JenisAduan::orderBy('nama_aduan')->get();
        return view('master.jenis-aduan.index', compact('jenisAduans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_aduan' => 'required|string|max:100'
        ]);

        JenisAduan::create($request->only('nama_aduan'));

        return back()->with('success', 'Jenis aduan berhasil ditambahkan');
    }

    public function update(Request $request, JenisAduan $jenis_aduan)
    {
        $request->validate([
            'nama_aduan' => 'required|string|max:100'
        ]);

        $jenis_aduan->update($request->only('nama_aduan'));

        return back()->with('success', 'Jenis aduan berhasil diperbarui');
    }

    public function destroy(JenisAduan $jenis_aduan)
    {
        $jenis_aduan->delete();

        return back()->with('success', 'Jenis aduan berhasil dihapus');
    }
}
