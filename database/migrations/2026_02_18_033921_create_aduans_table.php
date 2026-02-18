<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aduans', function (Blueprint $table) {

            $table->id();

            // DATA UTAMA
            $table->date('tanggal');

            $table->time('jam')->nullable();

            $table->string('pelapor')->nullable();

            $table->enum('media_pelaporan', [
                'WA',
                'IG',
                'FB',
                'X',
                'Lapor Semar',
                'Call Center',
                'Email',
                'Datang Langsung'
            ]);

            // RELASI
            $table->foreignId('koridor_id')
                ->constrained('master_koridors')
                ->cascadeOnDelete();

            $table->foreignId('jenis_aduan_id')
                ->constrained('master_jenis_aduans')
                ->cascadeOnDelete();


            // OPERASIONAL
            $table->string('pta')->nullable();

            $table->string('pengemudi')->nullable();

            $table->string('no_armada')->nullable();

            $table->string('tkp')->nullable();


            // ISI
            $table->text('isi_aduan');

            $table->enum('status', ['Belum','Selesai'])
                ->default('Belum');

            $table->text('keterangan_tindak_lanjut')->nullable();


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduans');
    }
};
