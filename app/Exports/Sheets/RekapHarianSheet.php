<?php

namespace App\Exports\Sheets;

use App\Models\Aduan;
use App\Models\JenisAduan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class RekapHarianSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $days = range(1, 31);
        $header = array_merge(['No','Jenis Aduan'], $days, ['Total']);
        $rows = [$header];

        $no = 1;
        foreach (JenisAduan::all() as $jenis) {
            $row = [$no++, $jenis->nama_aduan];
            $total = 0;

            foreach ($days as $day) {
                $count = Aduan::where('jenis_aduan_id', $jenis->id)
                    ->whereDate('tanggal', Carbon::create(2026, 1, $day))
                    ->count();

                $row[] = $count;
                $total += $count;
            }

            $row[] = $total;
            $rows[] = $row;
        }

        return $rows;
    }

    public function title(): string
    {
        return 'REKAP_HARIAN_JAN_2026';
    }
}
