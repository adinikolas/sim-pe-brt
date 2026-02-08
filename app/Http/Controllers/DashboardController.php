<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Koridor;
use Carbon\Carbon;
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
        $aduanPerBulan = Aduan::selectRaw('
                YEAR(tanggal) as tahun,
                MONTH(tanggal) as bulan,
                COUNT(*) as total
            ')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        // untuk grafik
        $chartLabels = [];
        $chartData = [];

        foreach ($aduanPerBulan as $item) {
            $chartLabels[] = Carbon::create()
                ->month($item->bulan)
                ->locale('id')
                ->translatedFormat('F') . ' ' . $item->tahun;

            $chartData[] = $item->total;
        }

        return view('dashboard.index', compact(
            'totalAduan',
            'aduanSelesai',
            'aduanBelum',
            'aduanPerKoridor',
            'aduanPerBulan',
            'chartLabels',
            'chartData'
        ));
    }
}
