<?php

namespace App\Exports;

use App\Models\Koridor;
use App\Models\Aduan;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\{
    WithMultipleSheets,
    FromCollection,
    WithHeadings,
    WithMapping,
    WithTitle,
    ShouldAutoSize,
    WithStyles,
    WithEvents
};

use App\Exports\Sheets\AduanPerKoridorSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;

class AduanExport implements
    WithMultipleSheets,
    FromCollection,
    WithHeadings,
    WithMapping,
    WithTitle,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{

    protected $bulan;
    protected $tahun;
    protected $no = 1;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /*
    |--------------------------------------------------------------------------
    | MODE MULTIPLE SHEET ATAU SINGLE SHEET
    |--------------------------------------------------------------------------
    */

    public function sheets(): array
    {
        // Jika tidak ada filter → hanya 1 sheet
        if (!$this->bulan && !$this->tahun) {
            return [$this];
        }

        // Jika ada filter → semua + per koridor
        $sheets = [];

        // Sheet semua
        $sheets[] = new self($this->bulan, $this->tahun);

        // Sheet per koridor
        foreach (Koridor::orderBy('nama_koridor')->get() as $koridor) {

            $sheets[] = new AduanPerKoridorSheet(
                $koridor,
                $this->bulan,
                $this->tahun
            );
        }

        return $sheets;
    }

    /*
    |--------------------------------------------------------------------------
    | DATA QUERY
    |--------------------------------------------------------------------------
    */

    public function collection()
    {
        $query = Aduan::with('jenisAduan')
            ->orderBy('tanggal', 'desc');

        if ($this->bulan)
            $query->whereMonth('tanggal', $this->bulan);

        if ($this->tahun)
            $query->whereYear('tanggal', $this->tahun);

        return $query->get();
    }

    /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
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
            'Keterangan',
            'Status',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | MAP DATA
    |--------------------------------------------------------------------------
    */

    public function map($aduan): array
    {
        return [
            $this->no++,
            Carbon::parse($aduan->tanggal)->format('d-m-Y'),
            $aduan->jam,
            $aduan->pelapor,
            $aduan->media_pelaporan,
            $aduan->pta,
            $aduan->pengemudi,
            $aduan->no_armada,
            $aduan->tkp,
            $aduan->jenisAduan->nama_aduan ?? '',
            $aduan->isi_aduan,
            $aduan->keterangan_tindak_lanjut,
            $aduan->status,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | TITLE
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        if ($this->bulan && $this->tahun) {
            return 'SEMUA DATA';
        }

        return 'DATA ADUAN';
    }

    /*
    |--------------------------------------------------------------------------
    | STYLE
    |--------------------------------------------------------------------------
    */

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | TITLE HEADER
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function ($event) {

                $sheet = $event->sheet;

                // insert 3 baris untuk title
                $sheet->insertNewRowBefore(1, 3);

                // merge title
                $sheet->mergeCells('A1:M1');
                $sheet->mergeCells('A2:M2');
                $sheet->mergeCells('A3:M3');

                $sheet->setCellValue('A1', 'DATA ADUAN');
                $sheet->setCellValue('A2', 'BRT TRANS SEMARANG');

                if ($this->bulan && $this->tahun) {

                    $bulanText = \Carbon\Carbon::create(
                        $this->tahun,
                        $this->bulan
                    )->locale('id')->translatedFormat('F Y');

                    $sheet->setCellValue(
                        'A3',
                        'BULAN ' . strtoupper($bulanText)
                    );

                } else {

                    $sheet->setCellValue('A3', 'SEMUA DATA');

                }

                // STYLE TITLE CENTER + BOLD
                $sheet->getStyle('A1:A3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ]
                ]);

                // HEADER STYLE
                $sheet->getStyle('A4:M4')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // BORDER SELURUH TABEL
                $highestRow = $sheet->getHighestRow();

                $sheet->getStyle("A4:M{$highestRow}")
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
