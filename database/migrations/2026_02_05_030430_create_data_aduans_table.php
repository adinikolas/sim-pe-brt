<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_aduans', function (Blueprint $table) {
            $table->id(); // id_aduan
            $table->date('tanggal');

            $table->foreignId('koridor_id')
                ->constrained('master_koridors')
                ->onDelete('cascade');

            $table->foreignId('jenis_aduan_id')
                ->constrained('master_jenis_aduans')
                ->onDelete('cascade');

            $table->enum('media_pelaporan', ['WA', 'IG', 'Lapor Semar']);
            $table->text('isi_aduan');

            $table->enum('status', ['Selesai', 'Belum'])
                ->default('Belum');

            $table->text('keterangan_tindak_lanjut')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_aduans');
    }
};

