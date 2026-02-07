<?php

namespace App\Http\Controllers;

use App\Models\Koridor;
use Illuminate\Http\Request;

class KoridorController extends Controller
{
    public function index()
    {
        $koridors = Koridor::orderBy('nama_koridor')->get();
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
        $koridor->delete();

        return back()->with('success', 'Koridor berhasil dihapus');
    }
}

