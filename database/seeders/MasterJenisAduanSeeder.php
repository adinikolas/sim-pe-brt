<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterJenisAduanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_jenis_aduans')->insertOrIgnore([
            [
                'nama_aduan' => 'Komplain Pelayanan Pengemudi (tidak merapat halte, melebihi batas kecepatan, melanggar lalin, merokok, bermain hp, dll)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain Pelayanan Petugas BRT (kurang ramah, tidak sopan, kurang inisiatif, dll)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain Kondisi Armada (ac, pintu, mesin, dll)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain Kondisi Halte/Rambu (rusak, kotor, kurang nyaman, dll)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain Interval Armada dan Waktu Pelayanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain Tiket (tidak dapat kembalian, mesin error, tarif tidak sesuai, dll)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain Jalur Tidak Sesuai (ngelop)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain Rute (memutar tidak efisien)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain PNP Penuh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Komplain Aplikasi / Sosial Media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Saran Penambahan Jalur Khusus BRT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Saran Penambahan Halte/Rambu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Saran Penambahan Armada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Saran Penambahan Jam Layanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Saran Penambahan Rute',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
