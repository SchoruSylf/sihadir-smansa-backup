<?php

use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\HistoryController;
use BladeUIKit\Components\Forms\Inputs\Input;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('masuk');
Route::post('/masuk', [LoginController::class, 'login'])->name('masuk.proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('keluar');

Route::group(['prefix' => 'user', 'middleware' => ['auth'], 'as' => 'user.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Guru
    Route::get('/presensi-guru', [PresensiController::class, 'guru'])->name('presensi.guru');
    Route::put('/update-guru{detail_presensi}', [PresensiController::class, 'update_presensi'])->name('presensi.update');
    Route::get('/history', [HistoryController::class, 'read'])->name('history.presensi');
    //Siswa
    Route::get('/presensi-siswa', [PresensiController::class, 'index'])->name('presensi.siswa');
    Route::post('/presensis', [PresensiController::class, 'check_face'])->name('presensis');
    Route::put('/presensi-validasi', [PresensiController::class, 'presensi_validasi'])->name('presensi.validasi');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/histories', [HistoryController::class, 'read'])->name('history');

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');

    Route::prefix('input')->group(function () {

        // User Routes
        Route::prefix('user')->group(function () {
            Route::get('/', [InputController::class, 'user_read'])->name('user.read');
            Route::post('/input', [InputController::class, 'user_input'])->name('user.input');
            Route::post('/inputs', [InputController::class, 'user_input_mass'])->name('user.input.mass');
            Route::get('/export', [ExportController::class, 'user_export'])->name('user.export');
            Route::get('/exports', [ExportController::class, 'user_export_dummy'])->name('user.exports');
            Route::get('/edit/{id_user}', [InputController::class, 'user_edit'])->name('user.edit');
            Route::put('/update/{id_user}', [InputController::class, 'user_update'])->name('user.update');
            Route::delete('/delete/{id_user}', [InputController::class, 'user_delete'])->name('user.delete');
        });

        // Kelas Routes
        Route::prefix('kelas')->group(function () {
            Route::get('/', [InputController::class, 'kelas_read'])->name('kelas.read');
            Route::post('/input', [InputController::class, 'kelas_input'])->name('kelas.input');
            Route::get('/edit/{id_kelas}', [InputController::class, 'kelas_edit'])->name('kelas.edit');
            Route::put('/update/{id_kelas}', [InputController::class, 'kelas_update'])->name('kelas.update');
            Route::delete('/delete/{id_kelas}', [InputController::class, 'kelas_delete'])->name('kelas.delete');

            // User Kelas Routes
            Route::get('/read_user/{id_kelas}', [InputController::class, 'kelas_read_user'])->name('kelas.read_user');
            Route::get('/read_selector_user/{id_kelas}', [InputController::class, 'kelas_read_selector_user'])->name('kelas.read_selector_user');
            Route::post('/input_user/{id_kelas}', [InputController::class, 'kelas_input_user'])->name('kelas.input_user');
            Route::delete('/kelas/delete_user/{id_kelas}/{id_userKelas}', [InputController::class, 'kelas_delete_user'])->name('kelas.delete_user');
        });

        // Mata Pelajaran Routes
        Route::prefix('mata-pelajaran')->group(function () {
            Route::get('/', [InputController::class, 'mapel_read'])->name('mapel.read');
            Route::post('/input', [InputController::class, 'mapel_input'])->name('mapel.input');
            Route::get('/edit/{id_mapel}', [InputController::class, 'mapel_edit'])->name('mapel.edit');
            Route::put('/update/{id_mapel}', [InputController::class, 'mapel_update'])->name('mapel.update');
            Route::delete('/delete/{id_mapel}', [InputController::class, 'mapel_delete'])->name('mapel.delete');
        });

        // Schedule (Jadwal) Routes
        Route::prefix('jadwal')->group(function () {
            Route::get('/', [InputController::class, 'jadwal_read'])->name('jadwal.read');
            Route::post('/input', [InputController::class, 'jadwal_input'])->name('jadwal.input');
            Route::post('/inputs', [InputController::class, 'jadwal_input_mass'])->name('jadwal.input.mass');
            Route::get('/export', [ExportController::class, 'jadwal_export'])->name('jadwal.export');
            Route::get('/read_selector_user', [InputController::class, 'jadwal_read_selector_user'])->name('jadwal.read_selector_user');
            Route::get('/read_selector_kelas', [InputController::class, 'jadwal_read_selector_kelas'])->name('jadwal.read_selector_kelas');
            Route::get('/read_selector_mapel', [InputController::class, 'jadwal_read_selector_mapel'])->name('jadwal.read_selector_mapel');
            Route::get('/exports', [ExportController::class, 'jadwal_export_dummy'])->name('jadwal.exports');
            Route::get('/edit/{id_jadwal}', [InputController::class, 'jadwal_edit'])->name('jadwal.edit');
            Route::put('/update/{id_jadwal}', [InputController::class, 'jadwal_update'])->name('jadwal.update');
            Route::delete('/delete/{id_jadwal}', [InputController::class, 'jadwal_delete'])->name('jadwal.delete');
        });
    });
});
