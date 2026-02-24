<?php

namespace App\Exports\Sheets;

use App\Models\Koridor;
use App\Models\JenisAduan;
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

class RankingSheet implements
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

        // kosongkan baris untuk title
        $rows[]=[''];
        $rows[]=[''];
        $rows[]=[''];
        $rows[]=[''];

        $koridors=Koridor::orderBy('nama_koridor')->get();

        $header=['No','Jenis Aduan'];

        foreach($koridors as $k)
            $header[]=$k->nama_koridor;

        $header[]='Total';
        $header[]='Peringkat';

        $rows[]=$header;

        $data=[];
        $grandTotals=array_fill(0,count($koridors),0);
        $grandTotalAll=0;

        foreach(JenisAduan::orderBy('nama_aduan')->get() as $jenis)
        {

            $counts=[];
            $total=0;

            foreach($koridors as $index=>$k)
            {

                $count=Aduan::where('koridor_id',$k->id)
                    ->where('jenis_aduan_id',$jenis->id)
                    ->whereMonth('tanggal',$this->bulan)
                    ->whereYear('tanggal',$this->tahun)
                    ->count();

                $counts[]=$count;
                $total+=$count;

                $grandTotals[$index]+=$count;
            }

            $grandTotalAll+=$total;

            $data[]=[
                'jenis'=>$jenis->nama_aduan,
                'counts'=>$counts,
                'total'=>$total
            ];
        }

        // sort ranking
        usort($data,fn($a,$b)=>$b['total']<=>$a['total']);

        $rank=1;

        foreach($data as $d)
        {
            $row=[
                $rank,
                $d['jenis']
            ];

            foreach($d['counts'] as $c)
                $row[]=$c;

            $row[]=$d['total'];
            $row[]=$rank;

            $rows[]=$row;

            $rank++;
        }

        // TOTAL row
        $totalRow=['','TOTAL ADUAN'];

        foreach($grandTotals as $gt)
            $totalRow[]=$gt;

        $totalRow[]=$grandTotalAll;
        $totalRow[]='';

        $rows[]=$totalRow;

        return new Collection($rows);
    }

    public function title(): string
    {
        return 'Ranking';
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
        $sheet->getStyle("A6:A{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("C6:{$highestColumn}{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A6:{$highestColumn}{$highestRow}")
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

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

                $highestColumn = $sheet->getHighestColumn();

                // Merge title
                $sheet->mergeCells("A1:{$highestColumn}1");
                $sheet->mergeCells("A2:{$highestColumn}2");
                $sheet->mergeCells("A3:{$highestColumn}3");

                // Title text
                $sheet->setCellValue('A1','REKAPITULASI ADUAN & SARAN');
                $sheet->setCellValue('A2','BRT TRANS SEMARANG');
                $sheet->setCellValue('A3','BULAN '.strtoupper($bulanText));

                // Style title
                $sheet->getStyle('A1:A3')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'size'=>14
                    ],
                    'alignment'=>[
                        'horizontal'=>Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // Header style
                $sheet->getStyle("A5:{$highestColumn}5")->applyFromArray([
                    'font'=>[
                        'bold'=>true
                    ],
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

                // TOTAL row bold
                $highestRow = $sheet->getHighestRow();

                $sheet->getStyle("A{$highestRow}:{$highestColumn}{$highestRow}")
                    ->getFont()->setBold(true);

            }

        ];
    }

}
