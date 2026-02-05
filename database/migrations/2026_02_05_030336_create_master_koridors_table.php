<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_koridors', function (Blueprint $table) {
            $table->id(); // id_koridor
            $table->string('nama_koridor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_koridors');
    }
};

