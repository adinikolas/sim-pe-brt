<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\PerKoridorSheet;
use App\Exports\Sheets\TotalSheet;
use App\Exports\Sheets\RankingSheet;
use App\Exports\Sheets\RankingKoridorSheet;

class RekapBulananExport implements WithMultipleSheets
{
    protected $bulan,$tahun;

    public function __construct($bulan,$tahun)
    {
        $this->bulan=$bulan;
        $this->tahun=$tahun;
    }

    public function sheets(): array
    {
        return [

            new PerKoridorSheet($this->bulan,$this->tahun),

            new TotalSheet($this->bulan,$this->tahun),

            new RankingSheet($this->bulan,$this->tahun),

            new RankingKoridorSheet($this->bulan,$this->tahun),

        ];
    }
}
