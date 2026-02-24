<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AduanExport;
use App\Exports\RekapBulananExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportController extends Controller
{

    /**
     * HALAMAN EXPORT
     */
    public function index()
    {
        return view('export.index');
    }


    /**
     * EXPORT DATA ADUAN (FILTER / SEMUA)
     */
    public function excel(Request $request)
    {
        $bulan   = $request->bulan;
        $tahun   = $request->tahun;

        if (($bulan && !$tahun) || (!$bulan && $tahun))
        {
            return back()->with('error','Pilih bulan dan tahun');
        }

        if ($bulan && $tahun)
        {
            $namaFile =
                'Aduan_' .
                Carbon::create($tahun,$bulan)
                    ->translatedFormat('F_Y')
                . '.xlsx';
        }
        else
        {
            $namaFile = 'Aduan_Semua_Data.xlsx';
        }

        return Excel::download(
            new AduanExport($bulan,$tahun),
            $namaFile
        );
    }


    /**
     * EXPORT REKAP BULANAN FORMAT BRT
     */
    public function rekapBulanan(Request $request)
    {

        $bulan   = $request->bulan;
        $tahun   = $request->tahun;

        if (!$bulan || !$tahun)
        {
            return back()->with('error','Pilih bulan dan tahun');
        }

        $namaFile =
            'Rekap_Aduan_Saran_' .
            Carbon::create($tahun,$bulan)
                ->translatedFormat('F_Y')
            . '.xlsx';

        return Excel::download(
            new RekapBulananExport($bulan,$tahun),
            $namaFile
        );
    }

}
