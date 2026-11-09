<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes - Tugas Pertemuan 7: Routing, Controller & Blade
| Studi Kasus: Sistem Kehilangan dan Temuan Barang di Lingkungan Kampus
| Mahasiswa: Julian Atha Maulana (NIM: 20251020052)
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman utama daftar laporan
Route::get('/', function () {
    return redirect()->route('laporan.index');
});

// 1. Route Praktikum: Menampilkan daftar seluruh laporan (OOP Polymorphism)
Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');

// 2. Route Praktikum: Menampilkan detail satu laporan dengan Parameter Wajib {id}
Route::get('/laporan/{id}', [LaporanController::class, 'show'])
    ->name('laporan.show');

// 3. Route Tugas Rumah: Menampilkan simulasi klaim dengan Parameter Opsional {status?}
Route::get('/klaim/{status?}', [LaporanController::class, 'klaim'])
    ->name('laporan.klaim');
