<?php

namespace App\Exports\Sheets;

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

class TotalSheet implements
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

        // header table
        $rows[]=[
            'No',
            'Jenis Aduan',
            'Sosial Media',
            'Lapor Semar',
            'Call Center',
            'Email',
            'Datang Langsung',
            'Total'
        ];

        $jenisAduans = JenisAduan::orderBy('nama_aduan')->get();

        $no=1;
        $grandTotal=0;

        foreach($jenisAduans as $jenis)
        {

            $sosmed = Aduan::where('jenis_aduan_id',$jenis->id)
                ->whereIn('media_pelaporan',['WA','IG','FB','X'])
                ->whereMonth('tanggal',$this->bulan)
                ->whereYear('tanggal',$this->tahun)
                ->count();

            $lapor = Aduan::where('jenis_aduan_id',$jenis->id)
                ->where('media_pelaporan','Lapor Semar')
                ->whereMonth('tanggal',$this->bulan)
                ->whereYear('tanggal',$this->tahun)
                ->count();

            $call = Aduan::where('jenis_aduan_id',$jenis->id)
                ->where('media_pelaporan','Call Center')
                ->whereMonth('tanggal',$this->bulan)
                ->whereYear('tanggal',$this->tahun)
                ->count();

            $email = Aduan::where('jenis_aduan_id',$jenis->id)
                ->where('media_pelaporan','Email')
                ->whereMonth('tanggal',$this->bulan)
                ->whereYear('tanggal',$this->tahun)
                ->count();

            $datang = Aduan::where('jenis_aduan_id',$jenis->id)
                ->where('media_pelaporan','Datang Langsung')
                ->whereMonth('tanggal',$this->bulan)
                ->whereYear('tanggal',$this->tahun)
                ->count();

            $total = $sosmed+$lapor+$call+$email+$datang;

            $rows[]=[
                $no++,
                $jenis->nama_aduan,
                $sosmed,
                $lapor,
                $call,
                $email,
                $datang,
                $total
            ];

            $grandTotal += $total;
        }

        // TOTAL ADUAN row
        $rows[]=[
            '',
            'TOTAL ADUAN',
            '',
            '',
            '',
            '',
            '',
            $grandTotal
        ];

        return new Collection($rows);
    }

    public function title(): string
    {
        return 'Total';
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

        $sheet->getStyle("C6:H{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A6:H{$highestRow}")
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
                $highestRow = $sheet->getHighestRow();

                // merge title
                $sheet->mergeCells("A1:{$highestColumn}1");
                $sheet->mergeCells("A2:{$highestColumn}2");
                $sheet->mergeCells("A3:{$highestColumn}3");

                // set title
                $sheet->setCellValue('A1','REKAPITULASI ADUAN & SARAN');
                $sheet->setCellValue('A2','BRT TRANS SEMARANG');
                $sheet->setCellValue('A3','BULAN '.strtoupper($bulanText));

                // style title
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
                $sheet->getStyle("A{$highestRow}:{$highestColumn}{$highestRow}")
                    ->getFont()->setBold(true);

            }

        ];
    }

}
