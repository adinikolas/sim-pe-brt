<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\AduanLampiran;
use App\Models\Koridor;
use App\Models\JenisAduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AduanController extends Controller
{
    /**
     * Menampilkan daftar aduan
     */
    public function index(Request $request)
    {
        $query = Aduan::with(['koridor','jenisAduan']);

        // ================= SORTING =================
        switch ($request->get('sort')) {

            // 1. Waktu input (created_at)
            case 'input':
                $query->orderBy('created_at', 'desc');
                break;

            // 2. Status saja (Belum di atas)
            case 'status':
                $query->orderByRaw("status = 'Belum' DESC")
                    ->orderBy('created_at', 'desc');
                break;

            // 3. Status lalu tanggal
            case 'status_tanggal':
                $query->orderByRaw("status = 'Belum' DESC")
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('jam', 'desc');
                break;

            // DEFAULT: Tanggal Aduan
            default:
                $query->orderBy('tanggal', 'desc')
                    ->orderBy('jam', 'desc')
                    ->orderBy('id', 'desc');
                break;
        }

        // ================= FILTER =================
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // ================= SEARCH =================
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('pelapor', 'like', "%$q%")
                    ->orWhere('media_pelaporan', 'like', "%$q%")
                    ->orWhere('no_armada', 'like', "%$q%")
                    ->orWhereHas('koridor', fn($k) =>
                        $k->where('nama_koridor', 'like', "%$q%"))
                    ->orWhereHas('jenisAduan', fn($j) =>
                        $j->where('nama_aduan', 'like', "%$q%"));
            });
        }

        $aduans = $query->get();

        return view('aduan.index', compact('aduans'));
    }

    /**
     * Form tambah aduan
     */
    public function create()
    {
        $koridors = Koridor::all();
        $jenisAduans = JenisAduan::all();

        return view('aduan.create', compact('koridors', 'jenisAduans'));
    }

    /**
     * Simpan aduan + lampiran
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

            // VALIDASI LAMPIRAN
            'lampirans.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['status'] = 'Belum';

        $aduan = Aduan::create($validated);

        // SIMPAN LAMPIRAN
        if ($request->hasFile('lampirans')) {
            foreach ($request->file('lampirans') as $file) {
                $path = $file->store('aduan', 'public');

                $aduan->lampirans()->create([
                    'file_path' => $path
                ]);
            }
        }

        return redirect()
            ->route('aduan.index')
            ->with('success', 'Data aduan berhasil disimpan');
    }

    /**
     * Detail laporan (WEB, bukan JSON)
     */
    public function show(Aduan $aduan)
    {
        $aduan->load(['koridor', 'jenisAduan', 'lampirans']);

        return view('aduan.show', compact('aduan'));
    }

    /**
     * Form edit aduan
     */
    public function edit($id)
    {
        $aduan = Aduan::with('lampirans')->findOrFail($id);
        $koridors = Koridor::all();
        $jenisAduans = JenisAduan::all();

        return view('aduan.edit', compact('aduan', 'koridors', 'jenisAduans'));
    }

    /**
     * Update aduan + tambah lampiran baru
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

            // VALIDASI LAMPIRAN BARU
            'lampirans.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $aduan->update($validated);

        // TAMBAH LAMPIRAN BARU (TIDAK MENGHAPUS YANG LAMA)
        if ($request->hasFile('lampirans')) {
            foreach ($request->file('lampirans') as $file) {
                $path = $file->store('aduan', 'public');

                $aduan->lampirans()->create([
                    'file_path' => $path
                ]);
            }
        }

        return redirect()
            ->route('aduan.index')
            ->with('success', 'Data aduan berhasil diperbarui');
    }

    /**
     * Hapus aduan + semua lampiran
     */
    public function destroy($id)
    {
        $aduan = Aduan::with('lampirans')->findOrFail($id);

        foreach ($aduan->lampirans as $lampiran) {
            Storage::disk('public')->delete($lampiran->file_path);
            $lampiran->delete();
        }

        $aduan->delete();

        return back()->with('success', 'Data aduan berhasil dihapus');
    }

    /**
     * Hapus satu lampiran gambar
     */
    public function destroyLampiran(AduanLampiran $lampiran)
    {
        // hapus file fisik
        Storage::disk('public')->delete($lampiran->file_path);

        // hapus data lampiran
        $lampiran->delete();

        return back()->with('success', 'Lampiran berhasil dihapus');
    }
}
