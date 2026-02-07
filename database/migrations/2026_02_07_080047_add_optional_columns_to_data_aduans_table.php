<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('data_aduans', function (Blueprint $table) {
            $table->time('jam')->nullable()->after('tanggal');
            $table->string('pelapor')->nullable()->after('jam');
            $table->string('pta')->nullable()->after('media_pelaporan');
            $table->string('pengemudi')->nullable()->after('pta');
            $table->string('no_armada')->nullable()->after('pengemudi');
            $table->string('tkp')->nullable()->after('no_armada');
        });
    }

    public function down(): void
    {
        Schema::table('data_aduans', function (Blueprint $table) {
            $table->dropColumn([
                'jam','pelapor','pta','pengemudi','no_armada','tkp'
            ]);
        });
    }
};
