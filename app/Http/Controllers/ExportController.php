<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AduanExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function excel(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // cegah export filter setengah
        if (($bulan && !$tahun) || (!$bulan && $tahun)) {
            return back()->with('error', 'Pilih bulan dan tahun');
        }

        // cegah non-admin export semua
        if (!$bulan && !$tahun && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $namaFile = 'Aduan_' . (
            $bulan && $tahun
                ? \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F_Y')
                : 'Semua_Data'
        ) . '.xlsx';

        return Excel::download(
            new AduanExport($bulan, $tahun),
            $namaFile
        );
    }
}

