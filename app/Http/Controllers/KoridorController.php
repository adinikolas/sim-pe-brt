<?php

namespace App\Http\Controllers;

use App\Models\Koridor;
use Illuminate\Http\Request;

class KoridorController extends Controller
{
    public function index()
    {
        // ambil + hitung jumlah aduan
        $koridors = Koridor::withCount('aduans')
            ->orderBy('nama_koridor')
            ->get();

        return view('master.koridor.index', compact('koridors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_koridor' => 'required|string|max:100'
        ]);

        Koridor::create($request->only('nama_koridor'));

        return back()->with('success', 'Koridor berhasil ditambahkan');
    }

    public function update(Request $request, Koridor $koridor)
    {
        $request->validate([
            'nama_koridor' => 'required|string|max:100'
        ]);

        $koridor->update($request->only('nama_koridor'));

        return back()->with('success', 'Koridor berhasil diperbarui');
    }

    public function destroy(Koridor $koridor)
    {
        // BLOK JIKA MASIH DIPAKAI DI ADUAN
        if ($koridor->aduans()->exists()) {
            return back()->with(
                'error',
                'Koridor tidak bisa dihapus karena masih digunakan pada data aduan.'
            );
        }

        $koridor->delete();

        return back()->with('success', 'Koridor berhasil dihapus');
    }
}
