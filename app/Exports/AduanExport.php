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
    protected $no = 1;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * DATA QUERY
     */
    public function collection()
    {
        $query = Aduan::with(['jenisAduan'])
            ->orderBy('tanggal', 'desc');

        if ($this->bulan) {
            $query->whereMonth('tanggal', $this->bulan);
        }

        if ($this->tahun) {
            $query->whereYear('tanggal', $this->tahun);
        }

        return $query->get();
    }

    /**
     * HEADER EXCEL
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jam',
            'Pelapor',
            'Media',
            'PTA',
            'Pengemudi',
            'No Armada',
            'TKP',
            'Jenis Aduan',
            'Isi Aduan',
            'Keterangan Tindak Lanjut',
            'Status',
        ];
    }

    /**
     * ISI PER BARIS
     */
    public function map($aduan): array
    {
        return [
            $this->no++,
            $aduan->tanggal?->format('d-m-Y'),
            $aduan->jam ?? '-',
            $aduan->pelapor ?? 'Anonim',
            $aduan->media_pelaporan,
            $aduan->pta ?? '-',
            $aduan->pengemudi ?? '-',
            $aduan->no_armada ?? '-',
            $aduan->tkp ?? '-',
            $aduan->jenisAduan->nama_aduan ?? '-',
            $aduan->isi_aduan,
            $aduan->keterangan_tindak_lanjut ?? '-',
            $aduan->status,
        ];
    }

    /**
     * STYLE EXCEL
     */
    public function styles(Worksheet $sheet)
    {
        // Wrap text semua kolom
        $sheet->getStyle('A:Z')->getAlignment()->setWrapText(true);

        // Align atas biar rapi kalau teks panjang
        $sheet->getStyle('A:Z')->getAlignment()
              ->setVertical(Alignment::VERTICAL_TOP);

        return [
            // Header
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
