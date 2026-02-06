<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterKoridorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_koridors')->insert([
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
                'nama_koridor' => 'Feeder A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_koridor' => 'Feeder B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
