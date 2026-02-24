<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterKoridorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_koridors')->insertOrIgnore([
            [
                'nama_koridor' => 'Koridor 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Koridor 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Koridor 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Koridor 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Koridor 5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Koridor 6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Koridor 7',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Koridor 8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Feeder 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Feeder 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Feeder 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Feeder 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
