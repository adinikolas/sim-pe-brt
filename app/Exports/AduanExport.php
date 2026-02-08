<?php

namespace App\Exports;

use App\Models\Aduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AduanExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles
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
            ->orderBy('tanggal', 'desc');

        if ($this->bulan) {
            $query->whereMonth('tanggal', $this->bulan);
        }

        if ($this->tahun) {
            $query->whereYear('tanggal', $this->tahun);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam',
            'Pelapor',
            'Koridor',
            'Jenis Aduan',
            'Media',
            'No Armada',
            'TKP',
            'Isi Aduan',
            'Status',
            'Keterangan Tindak Lanjut',
        ];
    }

    /**
     * Mapping data per baris
     */
    public function map($aduan): array
    {
        return [
            $aduan->tanggal->format('d-m-Y'),
            $aduan->jam ?? '-',
            $aduan->pelapor ?? 'Anonim',
            $aduan->koridor->nama_koridor ?? '-',
            $aduan->jenisAduan->nama_aduan ?? '-',
            $aduan->media_pelaporan,
            $aduan->no_armada ?? '-',
            $aduan->tkp ?? '-',
            $aduan->isi_aduan,
            $aduan->status,
            $aduan->keterangan_tindak_lanjut ?? '-',
        ];
    }

    /**
     * STYLE EXCEL
     */
    public function styles(Worksheet $sheet)
    {
        // Wrap text untuk SEMUA kolom
        $sheet->getStyle('A:Z')->getAlignment()->setWrapText(true);

        // Vertical align top (biar rapi kalau text panjang)
        $sheet->getStyle('A:Z')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        // Header style
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
