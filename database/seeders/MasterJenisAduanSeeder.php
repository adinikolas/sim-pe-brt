<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterJenisAduanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_jenis_aduans')->insert([
            [
                'nama_aduan' => 'Komplain Pelayanan Pengemudi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'AC Tidak Dingin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Bus Terlambat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Kondisi Bus Tidak Layak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_aduan' => 'Informasi Tidak Jelas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
