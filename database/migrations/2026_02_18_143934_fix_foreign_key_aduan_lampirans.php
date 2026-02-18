<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aduan_lampirans', function (Blueprint $table) {

            // Hapus foreign key lama
            $table->dropForeign(['aduan_id']);

        });

        Schema::table('aduan_lampirans', function (Blueprint $table) {

            // Tambahkan foreign key baru ke tabel aduans
            $table->foreign('aduan_id')
                ->references('id')
                ->on('aduans')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('aduan_lampirans', function (Blueprint $table) {

            $table->dropForeign(['aduan_id']);

        });

        Schema::table('aduan_lampirans', function (Blueprint $table) {

            // rollback ke data_aduans (opsional)
            $table->foreign('aduan_id')
                ->references('id')
                ->on('data_aduans')
                ->cascadeOnDelete();

        });
    }
};
