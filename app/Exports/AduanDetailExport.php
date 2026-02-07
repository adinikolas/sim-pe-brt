namespace App\Exports;

use App\Models\Aduan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class AduanDetailExport implements FromArray, WithTitle
{
    public function array(): array
    {
        $header = [
            'No','Tgl','Bln','Thn','Jam','Pelapor','Media Pengaduan',
            'PTA','Pengemudi','No Armada','TKP',
            'Substansi Pengaduan','Tindak Lanjut',
            'Status Tindak Lanjut','Status Laporan'
        ];

        $rows = [$header];
        $no = 1;

        foreach (Aduan::orderBy('tanggal')->get() as $aduan) {
            $date = Carbon::parse($aduan->tanggal);

            $rows[] = [
                $no++,
                $date->format('d'),
                $date->translatedFormat('F'),
                $date->format('Y'),
                $aduan->jam ?? '',
                $aduan->pelapor ?? 'Anonim',
                $aduan->media_pelaporan,
                '',
                '',
                $aduan->no_armada ?? '',
                $aduan->tkp ?? '',
                $aduan->isi_aduan,
                $aduan->keterangan_tindak_lanjut ?? '',
                $aduan->status,
                'Valid'
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'DAFTAR_ADUAN';
    }
}
