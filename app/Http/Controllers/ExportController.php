<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AduanExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function excel(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        /**
         * Cegah filter setengah
         */
        if (($bulan && !$tahun) || (!$bulan && $tahun)) {
            return back()->with('error', 'Pilih bulan dan tahun');
        }

        /**
         * Cegah non-admin export semua
         */
        if (!$bulan && !$tahun && auth()->user()->role !== 'admin') {
            abort(403, 'Tidak punya akses export semua data');
        }

        /**
         * Nama file
         */
        if ($bulan && $tahun) {
            $namaFile = 'Aduan_' .
                Carbon::create($tahun, $bulan)
                    ->locale('id')
                    ->translatedFormat('F_Y') . '.xlsx';
        } else {
            $namaFile = 'Aduan_Semua_Data.xlsx';
        }

        /**
         * Download Excel
         */
        return Excel::download(
            new AduanExport($bulan, $tahun),
            $namaFile
        );
    }
}
