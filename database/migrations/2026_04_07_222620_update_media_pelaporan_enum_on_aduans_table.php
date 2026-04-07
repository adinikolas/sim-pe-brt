<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE aduans
            MODIFY media_pelaporan
            ENUM(
                'WA',
                'IG',
                'FB',
                'X',
                'Telegram',
                'Lapor Semar',
                'Call Center',
                'Email',
                'Datang Langsung'
            )
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE aduans
            MODIFY media_pelaporan
            ENUM(
                'WA',
                'IG',
                'FB',
                'X',
                'Lapor Semar',
                'Call Center',
                'Email',
                'Datang Langsung'
            )
        ");
    }
};
