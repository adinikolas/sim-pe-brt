<?php

namespace App\Exports\Sheets;

use App\Models\Aduan;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    WithTitle,
    ShouldAutoSize,
    WithEvents
};

use Maatwebsite\Excel\Events\AfterSheet;

class AduanPerKoridorSheet implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithTitle,
    ShouldAutoSize,
    WithEvents
{

    protected $koridor;
    protected $bulan;
    protected $tahun;
    protected $no=1;

    public function __construct($koridor,$bulan,$tahun)
    {
        $this->koridor=$koridor;
        $this->bulan=$bulan;
        $this->tahun=$tahun;
    }

    public function collection()
    {
        return Aduan::with('jenisAduan')
            ->where('koridor_id',$this->koridor->id)
            ->whereMonth('tanggal',$this->bulan)
            ->whereYear('tanggal',$this->tahun)
            ->get();
    }

    public function headings(): array
    {
        return [
            'No','Tanggal','Jam','Pelapor','Media',
            'Jenis Aduan','Isi Aduan','Status'
        ];
    }

    public function map($aduan): array
    {
        return [
            $this->no++,
            \Carbon\Carbon::parse($aduan->tanggal)->format('d-m-Y'),
            $aduan->jam,
            $aduan->pelapor,
            $aduan->media_pelaporan,
            $aduan->jenisAduan->nama_aduan,
            $aduan->isi_aduan,
            $aduan->status
        ];
    }

    public function title(): string
    {
        return $this->koridor->nama_koridor;
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function ($event) {

                $sheet = $event->sheet;

                $sheet->insertNewRowBefore(1, 3);

                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                $sheet->mergeCells('A3:H3');

                $sheet->setCellValue(
                    'A1',
                    'DATA ADUAN ' . $this->koridor->nama_koridor
                );

                $sheet->setCellValue(
                    'A2',
                    'BRT TRANS SEMARANG'
                );

                $bulanText = \Carbon\Carbon::create(
                    $this->tahun,
                    $this->bulan
                )->locale('id')->translatedFormat('F Y');

                $sheet->setCellValue(
                    'A3',
                    'BULAN ' . strtoupper($bulanText)
                );

                // TITLE STYLE
                $sheet->getStyle('A1:A3')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'size'=>14
                    ],
                    'alignment'=>[
                        'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ]
                ]);

                // HEADER STYLE
                $sheet->getStyle('A4:H4')->applyFromArray([
                    'font'=>['bold'=>true],
                    'alignment'=>[
                        'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // BORDER
                $highestRow = $sheet->getHighestRow();

                $sheet->getStyle("A4:H{$highestRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    );

                // Center kolom No, Tanggal, Jam
                $sheet->getStyle("A5:C{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("A5:C{$highestRow}")
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

            }

        ];
    }
}
