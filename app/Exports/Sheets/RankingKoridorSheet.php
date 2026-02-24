<?php

namespace App\Exports\Sheets;

use App\Models\Koridor;
use App\Models\Aduan;
use Illuminate\Support\Collection;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithTitle,
    ShouldAutoSize,
    WithStyles,
    WithEvents
};

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class RankingKoridorSheet implements
    FromCollection,
    WithTitle,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{

    protected $bulan,$tahun;

    public function __construct($bulan,$tahun)
    {
        $this->bulan=$bulan;
        $this->tahun=$tahun;
    }

    public function collection()
    {

        $rows=[];

        // ruang untuk title
        $rows[]=[''];
        $rows[]=[''];
        $rows[]=[''];
        $rows[]=[''];

        // Header tabel
        $rows[]=[
            'KORIDOR/FEEDER',
            'TOTAL ADUAN',
            'PERINGKAT'
        ];

        $data=[];
        $grandTotal=0;

        foreach(Koridor::orderBy('nama_koridor')->get() as $koridor)
        {

            $total=Aduan::where('koridor_id',$koridor->id)
                ->whereMonth('tanggal',$this->bulan)
                ->whereYear('tanggal',$this->tahun)
                ->count();

            $data[]=[
                'nama'=>$koridor->nama_koridor,
                'total'=>$total
            ];

            $grandTotal+=$total;
        }

        // urut descending
        usort($data,function($a,$b){
            return $b['total'] <=> $a['total'];
        });

        $rank=1;

        foreach($data as $index=>$d)
        {
            $rows[]=[
                $d['nama'],
                $d['total'],
                $rank
            ];

            $rank++;
        }

        // TOTAL row
        $rows[]=[
            'TOTAL',
            $grandTotal,
            ''
        ];

        return new Collection($rows);
    }

    public function title(): string
    {
        return 'Peringkat Koridor';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // border
        $sheet->getStyle("A5:{$highestColumn}{$highestRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // center angka
        $sheet->getStyle("B6:C{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A5:C{$highestRow}")
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);

        return [];
    }

    public function registerEvents(): array
    {

        return [

            AfterSheet::class => function(AfterSheet $event)
            {

                $sheet = $event->sheet;

                $bulanText = Carbon::create($this->tahun,$this->bulan)
                    ->locale('id')
                    ->translatedFormat('F Y');

                $highestRow = $sheet->getHighestRow();

                // merge title
                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('A2:C2');
                $sheet->mergeCells('A3:C3');

                $sheet->setCellValue('A1','REKAPITULASI PERINGKAT KORIDOR');
                $sheet->setCellValue('A2','BRT TRANS SEMARANG');
                $sheet->setCellValue('A3','BULAN '.strtoupper($bulanText));

                $sheet->getStyle('A1:A3')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'size'=>14
                    ],
                    'alignment'=>[
                        'horizontal'=>Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // header style
                $sheet->getStyle('A5:C5')->applyFromArray([
                    'font'=>['bold'=>true],
                    'alignment'=>[
                        'horizontal'=>Alignment::HORIZONTAL_CENTER
                    ],
                    'fill'=>[
                        'fillType'=>Fill::FILL_SOLID,
                        'startColor'=>[
                            'argb'=>'FFEFEFEF'
                        ]
                    ]
                ]);

                // TOTAL bold
                $sheet->getStyle("A{$highestRow}:C{$highestRow}")
                    ->getFont()->setBold(true);

            }

        ];
    }

}
