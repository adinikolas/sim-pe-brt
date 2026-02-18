<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_jenis_aduans', function (Blueprint $table) {

            $table->string('kategori', 20)
                  ->after('nama_aduan')
                  ->default('Komplain');

        });
    }

    public function down(): void
    {
        Schema::table('master_jenis_aduans', function (Blueprint $table) {

            $table->dropColumn('kategori');

        });
    }
};
