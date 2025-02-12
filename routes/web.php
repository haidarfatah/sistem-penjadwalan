<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JadwalKerjaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\NotifikasiController;
// use Illuminate\Support\Facades\Route;

// ROUTE AUTH
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// DASHBOARD
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// HANYA ADMIN YANG BISA MENGAKSES HALAMAN BERIKUT
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/pengguna', PenggunaController::class);

    Route::prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/index', [KaryawanController::class, 'index'])->name('index');
        Route::get('/tambah', [KaryawanController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [KaryawanController::class, 'simpan'])->name('simpan');
        Route::get('/edit/{id_karyawan}', [KaryawanController::class, 'edit'])->name('edit');
        Route::put('/update/{id_karyawan}', [KaryawanController::class, 'update'])->name('update');
        Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');

        Route::put('/karyawan/{id_karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');

        Route::delete('/hapus/{id_karyawan}', [KaryawanController::class, 'hapus'])->name('hapus');
    });

    Route::prefix('jadwalkerja')->name('jadwalkerja.')->group(function () {
        Route::get('/', [JadwalKerjaController::class, 'index'])->name('index');
        Route::get('/tambah', [JadwalKerjaController::class, 'tambah'])->name('tambah');
        Route::post('/simpan', [JadwalKerjaController::class, 'simpan'])->name('simpan');
        Route::get('/ubah/{id}', [JadwalKerjaController::class, 'ubah'])->name('ubah');
        Route::post('/perbarui', [JadwalKerjaController::class, 'perbarui'])->name('perbarui'); // Ini yang benar
        Route::delete('/hapus/{id}', [JadwalKerjaController::class, 'hapus'])->name('hapus');
        Route::get('/jadwal-belum', [JadwalKerjaController::class, 'jadwalBelum'])->name('belum');
        Route::get('/jadwal-sudah', [JadwalKerjaController::class, 'jadwalSudah'])->name('sudah');
    });



    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('index'); // Menampilkan halaman absensi
    });
    
    
    Route::prefix('gaji')->name('gaji.')->group(function () { 
        Route::get('/', [PenggajianController::class, 'index'])->name('index'); 
        Route::get('/detail/{id_karyawan}', [PenggajianController::class, 'detailGaji'])->name('detail');
        Route::post('/serahkan/{id_karyawan}', [PenggajianController::class, 'serahkanGaji'])->name('serahkan');
    });
    
    
    Route::resource('/penggajian', PenggajianController::class);
    Route::resource('/lembur', LemburController::class);
    Route::resource('/notifikasi', NotifikasiController::class);
});



use App\Http\Controllers\AbsensiKaryawanController;

Route::middleware(['auth'])->group(function () {
    Route::get('/karyawan/absensi', [AbsensiKaryawanController::class, 'index'])->name('karyawan.absensi.index');
    Route::post('/karyawan/absensi/masuk', [AbsensiKaryawanController::class, 'masuk'])->name('karyawan.absensi.masuk');
    Route::post('/karyawan/absensi/keluar', [AbsensiKaryawanController::class, 'keluar'])->name('karyawan.absensi.keluar');
    Route::post('/karyawan/absensi/izin-sakit', [AbsensiKaryawanController::class, 'izinSakit'])->name('karyawan.absensi.izinSakit');
    Route::get('/karyawan/absensi/riwayat', [AbsensiKaryawanController::class, 'riwayat'])->name('karyawan.absensi.riwayat');
    
});
