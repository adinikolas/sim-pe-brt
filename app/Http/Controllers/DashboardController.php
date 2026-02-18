<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\models\JenisAduan;
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
        $aduanPerKoridor = Aduan::with('koridor')
        ->select('koridor_id', DB::raw('count(*) as total'))
        ->groupBy('koridor_id')
        ->get();

        // Rekap per bulan
        $aduanPerBulan = Aduan::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('YEAR(tanggal) as tahun'),
            DB::raw('count(*) as total')
        )
        ->groupBy('tahun','bulan')
        ->orderByDesc('tahun')
        ->orderByDesc('bulan')
        ->get();

        /*
        ===============================
        KLASIFIKASI ADUAN PER JENIS & MEDIA
        ===============================
        */

        $klasifikasi = DB::table('master_jenis_aduans')
            ->leftJoin('aduans', 'aduans.jenis_aduan_id', '=', 'master_jenis_aduans.id')
            ->select(
                'master_jenis_aduans.id',
                'master_jenis_aduans.nama_aduan',

                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(aduans.media_pelaporan)) IN ('wa','ig','fb','x')
                            THEN 1 ELSE 0
                        END
                    ) as sosial_media
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN aduans.media_pelaporan = 'Lapor Semar'
                            THEN 1 ELSE 0
                        END
                    ) as lapor_semar
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN aduans.media_pelaporan = 'Call Center'
                            THEN 1 ELSE 0
                        END
                    ) as call_center
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN aduans.media_pelaporan = 'Email'
                            THEN 1 ELSE 0
                        END
                    ) as email
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN aduans.media_pelaporan = 'Datang Langsung'
                            THEN 1 ELSE 0
                        END
                    ) as datang_langsung
                "),

                DB::raw("COUNT(aduans.id) as total")
            )
            ->groupBy(
                'master_jenis_aduans.id',
                'master_jenis_aduans.nama_aduan'
            )
            ->orderBy('master_jenis_aduans.nama_aduan')
            ->get();

        /*
        =========================
        DATA GRAFIK BULANAN
        =========================
        */

        $chartDataRaw = Aduan::selectRaw("
                MONTH(tanggal) as bulan,
                YEAR(tanggal) as tahun,
                COUNT(*) as total
            ")
            ->groupBy('tahun','bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $chartLabels = [];
        $chartData   = [];

        foreach ($chartDataRaw as $item) {

            $chartLabels[] = \Carbon\Carbon::create()
                ->month($item->bulan)
                ->locale('id')
                ->translatedFormat('F')
                . ' ' . $item->tahun;

            $chartData[] = $item->total;
        }

        return view('dashboard.index', compact(
            'totalAduan',
            'aduanSelesai',
            'aduanBelum',
            'aduanPerKoridor',
            'aduanPerBulan',
            'klasifikasi',
            'chartLabels',
            'chartData'
        ));
    }
}
