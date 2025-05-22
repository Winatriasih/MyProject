<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CatatanController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Route dashboard jadi halaman utama
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Auth routes (login, register, logout, dll)
Auth::routes();

// Redirect /home ke /dashboard agar konsisten halaman utama
Route::get('/home', function() {
    return redirect()->route('dashboard');
})->name('home');

// CRUD Tugas dengan penamaan parameter sesuai model (optional tapi bagus untuk kejelasan)
Route::resource('tugas', TugasController::class)->parameters([
    'tugas' => 'tugas'
]);

// CRUD Kategori
Route::resource('kategori', KategoriController::class);

// CRUD Catatan tanpa method show
Route::resource('catatan', CatatanController::class)
    ->except(['show'])
    ->parameters([
        'catatan' => 'catatan'
    ]);

// Route menampilkan tugas berdasarkan kategori
Route::get('/tugas/kategori/{id}', [TugasController::class, 'byKategori'])->name('tugas.kategori');

// Route pengecekan URL update (debug/testing)
Route::get('/cek', function () {
    // Contoh generate url untuk update tugas dengan id=1
    return route('tugas.update', ['tugas' => 1]);
});

// Route untuk update status tugas (HARUS di luar closure)
Route::patch('/tugas/{id}/status', [TugasController::class, 'ubahStatus'])->name('tugas.updateStatus');
