<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('data_aduans', function (Blueprint $table) {
            $table->string('media_pelaporan')->change();
        });
    }

    public function down(): void
    {
        Schema::table('data_aduans', function (Blueprint $table) {
            $table->enum('media_pelaporan', ['WA', 'IG', 'Lapor Semar'])->change();
        });
    }
};
