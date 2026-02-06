<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Koridor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total aduan
        $totalAduan = Aduan::count();

        // Status
        $aduanSelesai = Aduan::where('status', 'Selesai')->count();
        $aduanBelum = Aduan::where('status', 'Belum')->count();

        // Rekap per koridor
        $aduanPerKoridor = Aduan::select(
                'koridor_id',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('koridor_id')
            ->with('koridor')
            ->get();

        // Rekap per bulan
        $aduanPerBulan = Aduan::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy('bulan')
            ->get();

        return view('dashboard.index', compact(
            'totalAduan',
            'aduanSelesai',
            'aduanBelum',
            'aduanPerKoridor',
            'aduanPerBulan'
        ));
    }
}
