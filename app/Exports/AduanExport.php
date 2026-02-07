<?php

namespace App\Exports;

use App\Models\Aduan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AduanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = Aduan::with(['koridor', 'jenisAduan'])
            ->orderBy('tanggal');

        if ($this->bulan && $this->tahun) {
            $query->whereMonth('tanggal', $this->bulan)
                  ->whereYear('tanggal', $this->tahun);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jam',
            'Pelapor',
            'Koridor',
            'Jenis Aduan',
            'Media',
            'PTA',
            'Pengemudi',
            'No Armada',
            'TKP',
            'Isi Aduan',
            'Status',
            'Tindak Lanjut',
        ];
    }

    public function map($aduan): array
    {
        static $no = 1;

        return [
            $no++,
            $aduan->tanggal->format('d-m-Y'),
            $aduan->jam,
            $aduan->pelapor,
            optional($aduan->koridor)->nama_koridor,
            optional($aduan->jenisAduan)->nama_aduan,
            $aduan->media_pelaporan,
            $aduan->pta,
            $aduan->pengemudi,
            $aduan->no_armada,
            $aduan->tkp,
            $aduan->isi_aduan,
            $aduan->status,
            $aduan->keterangan_tindak_lanjut,
        ];
    }
}
