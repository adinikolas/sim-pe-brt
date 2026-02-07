<?php

namespace App\Exports\Sheets;

use App\Models\Aduan;
use App\Models\JenisAduan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class RekapAduanSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $mediaList = [
            'WA','IG','FB','X',
            'Lapor Semar','Call Center','Email','Datang Langsung'
        ];

        $header = array_merge(['No','Jenis Aduan'], $mediaList, ['Total']);
        $rows = [$header];

        $no = 1;
        foreach (JenisAduan::all() as $jenis) {
            $row = [$no++, $jenis->nama_aduan];
            $total = 0;

            foreach ($mediaList as $media) {
                $count = Aduan::where('jenis_aduan_id', $jenis->id)
                    ->where('media_pelaporan', $media)
                    ->whereMonth('tanggal', 1)
                    ->whereYear('tanggal', 2026)
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
        return 'REKAP_ADUAN';
    }
}
