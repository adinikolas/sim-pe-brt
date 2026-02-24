<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\KoridorController;
use App\Http\Controllers\JenisAduanController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ================= ADUAN =================
    Route::resource('aduan', AduanController::class);

    // HAPUS LAMPIRAN (PER GAMBAR)
    Route::delete(
        '/aduan/lampiran/{lampiran}',
        [AduanController::class, 'destroyLampiran']
    )->name('aduan.lampiran.destroy');

    // ================= MASTER DATA =================
    Route::resource('koridor', KoridorController::class)
        ->only(['index','store','update','destroy']);

    Route::resource('jenis-aduan', JenisAduanController::class)
        ->only(['index','store','update','destroy']);

    // ================= EXPORT =================

    // halaman export
    Route::get('/export', [ExportController::class, 'index'])
        ->name('export.index');

    // export data aduan (sesuai filter dan semua)
    Route::get('/export-excel', [ExportController::class, 'excel'])
        ->name('export.excel');

    // export rekap bulanan format BRT
    Route::get('/export-rekap-bulanan', [ExportController::class, 'rekapBulanan'])
        ->name('export.rekap.bulanan');

    // ================= PROFILE =================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
