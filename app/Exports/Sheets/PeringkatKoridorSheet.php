<?php

namespace App\Exports\Sheets;

use App\Models\Aduan;
use App\Models\Koridor;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class PeringkatKoridorSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $header = ['Koridor / Feeder', 'Total Aduan', 'Peringkat'];
        $rows = [$header];

        $data = Koridor::withCount(['aduans' => function ($q) {
            $q->whereMonth('tanggal', 1)->whereYear('tanggal', 2026);
        }])->orderByDesc('aduans_count')->get();

        $rank = 1;
        foreach ($data as $item) {
            $rows[] = [
                $item->nama_koridor,
                $item->aduans_count,
                $rank++
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'PERINGKAT_KORIDOR';
    }
}
