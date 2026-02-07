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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // CRUD Aduan (index, create, store, show, edit, update, destroy)
    Route::resource('aduan', AduanController::class);

    // CRUD Koridor & Jenis Aduan
    Route::middleware(['auth'])->group(function () {
        Route::resource('koridor', KoridorController::class)
            ->only(['index','store','update','destroy']);

        Route::resource('jenis-aduan', JenisAduanController::class)
            ->only(['index','store','update','destroy']);
    });

    // Export Excel
    Route::get('/export', function () {
        return view('export.index');
    })->middleware('auth')->name('export.index');

    Route::get('/export-excel', [ExportController::class, 'excel'])
        ->middleware('auth')
        ->name('export.excel');

    // Profile (bawaan Breeze, kalau masih dipakai)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
