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

class PerKoridorSheet implements
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

        $koridors = Koridor::orderBy('nama_koridor')->get();
        $jenisAduans = JenisAduan::orderBy('nama_aduan')->get();

        foreach($koridors as $koridor)
        {
            // 1 baris kosong sebelum koridor
            $rows[]=[''];

            // Nama Koridor
            $rows[]=['KORIDOR '.$koridor->nama_koridor];

            // HEADER BARIS 1
            $rows[]=[
                'No',
                'Jenis Aduan',
                'Jenis Aduan',
                '',
                '',
                '',
                '',
                'Total'
            ];

            // HEADER BARIS 2
            $rows[]=[
                '',
                '',
                'Sosial Media',
                'Lapor Semar',
                'Call Center',
                'Email',
                'Datang Langsung',
                ''
            ];

            $no=1;
            $grandTotal=0;

            foreach($jenisAduans as $jenis)
            {
                $sosmed = Aduan::where('koridor_id',$koridor->id)
                    ->where('jenis_aduan_id',$jenis->id)
                    ->whereIn('media_pelaporan',['WA','IG','FB','X'])
                    ->whereMonth('tanggal',$this->bulan)
                    ->whereYear('tanggal',$this->tahun)
                    ->count();

                $lapor = Aduan::where('koridor_id',$koridor->id)
                    ->where('jenis_aduan_id',$jenis->id)
                    ->where('media_pelaporan','Lapor Semar')
                    ->whereMonth('tanggal',$this->bulan)
                    ->whereYear('tanggal',$this->tahun)
                    ->count();

                $call = Aduan::where('koridor_id',$koridor->id)
                    ->where('jenis_aduan_id',$jenis->id)
                    ->where('media_pelaporan','Call Center')
                    ->whereMonth('tanggal',$this->bulan)
                    ->whereYear('tanggal',$this->tahun)
                    ->count();

                $email = Aduan::where('koridor_id',$koridor->id)
                    ->where('jenis_aduan_id',$jenis->id)
                    ->where('media_pelaporan','Email')
                    ->whereMonth('tanggal',$this->bulan)
                    ->whereYear('tanggal',$this->tahun)
                    ->count();

                $datang = Aduan::where('koridor_id',$koridor->id)
                    ->where('jenis_aduan_id',$jenis->id)
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

                $grandTotal+=$total;
            }

            // TOTAL ROW
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
        }

        return new Collection($rows);
    }

    public function title(): string
    {
        return 'Per Koridor';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Border semua tabel
        $sheet->getStyle("A5:{$highestColumn}{$highestRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Rata tengah semua angka (kolom A dan C sampai H)
        $sheet->getStyle("A6:A{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("C6:H{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // vertical center juga
        $sheet->getStyle("A6:H{$highestRow}")
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
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                $bulanText = Carbon::create($this->tahun,$this->bulan)
                    ->locale('id')
                    ->translatedFormat('F Y');

                // MERGE TITLE
                $sheet->mergeCells("A1:{$highestColumn}1");
                $sheet->mergeCells("A2:{$highestColumn}2");
                $sheet->mergeCells("A3:{$highestColumn}3");

                $sheet->setCellValue('A1','REKAPITULASI ADUAN & SARAN');
                $sheet->setCellValue('A2','BRT TRANS SEMARANG');
                $sheet->setCellValue('A3','BULAN '.strtoupper($bulanText));

                $sheet->getStyle('A1:A3')->applyFromArray([
                    'font'=>['bold'=>true,'size'=>14],
                    'alignment'=>[
                        'horizontal'=>Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // Loop cari setiap header koridor
                for($row=1;$row<=$highestRow;$row++)
                {
                    $value = $sheet->getCell("A{$row}")->getValue();

                    if(str_contains($value,'KORIDOR'))
                    {
                        // Merge header Jenis Aduan
                        $sheet->mergeCells("C".($row+1).":G".($row+1));

                        // Merge No, Jenis Aduan, Total
                        $sheet->mergeCells("A".($row+1).":A".($row+2));
                        $sheet->mergeCells("B".($row+1).":B".($row+2));
                        $sheet->mergeCells("H".($row+1).":H".($row+2));

                        // Style header
                        $sheet->getStyle("A".($row+1).":H".($row+2))->applyFromArray([
                            'font'=>['bold'=>true],
                            'alignment'=>[
                                'horizontal'=>Alignment::HORIZONTAL_CENTER,
                                'vertical'=>Alignment::VERTICAL_CENTER
                            ],
                            'fill'=>[
                                'fillType'=>Fill::FILL_SOLID,
                                'startColor'=>['argb'=>'FFEFEFEF']
                            ]
                        ]);

                        // TOTAL row bold
                        $sheet->getStyle("A".($row+2+count(JenisAduan::all())+1).":H".($row+2+count(JenisAduan::all())+1))
                            ->getFont()->setBold(true);
                    }
                }

            }

        ];
    }
}
