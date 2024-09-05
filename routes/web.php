<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', function () {
    return view('landing');
});

// Halaman Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('loginaksi', [LoginController::class, 'loginaksi'])->name('loginaksi');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman Publik
Route::get('/landing', function () {
    return view('landing');
});

// Middleware Auth Group
Route::middleware('auth')->group(function () {

    // Home dan Menu
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/menu', function () {
        return view('menu');
    });

    // Profil dan Kontak
    Route::get('/tentang', function () {
        return view('profile.tentang');
    });
    Route::get('/kontak', function () {
        return view('profile.kontak');
    });
    Route::get('/profil', function () {
        return view('profile.profil');
    });

    // Guru
    Route::get('/guru', 'GuruController@gurutampil');
    Route::post('/guru/tambah', 'GuruController@tambah');
    Route::get('/guru/edit/{id}', 'GuruController@edit');
    Route::post('/guru/update/{id}', 'GuruController@update');
    Route::delete('/guru/delete', 'GuruController@delete');
    Route::get('/guru/gajiperjam/{id}', 'GuruController@getGajiPerJam');

    // Absen
    Route::get('/absen', 'AbsenController@absentampil');
    Route::post('/absen/tambah', 'AbsenController@tambah');
    Route::get('/absen/edit/{id}', 'AbsenController@edit');
    Route::post('/absen/update/{id}', 'AbsenController@update');
    Route::delete('/absen/delete', 'AbsenController@delete');
    
    // web.php atau api.php
    Route::get('/absen/gajiperjam/{id}', 'GajiController@getGajiPerJam');
    Route::get('/absen/data/{id}', 'GajiController@getAbsenData');
    Route::get('/absen/idabsen/{id}', 'GajiController@getIdAbsen');

    // Gaji
    Route::get('/gaji', 'GajiController@gajitampil');
    Route::post('/gaji/tambah', 'GajiController@tambah');
    Route::delete('/gaji/delete', 'GajiController@delete');
    Route::get('/gaji/cetak-pdf/{bulan}/{id?}', 'GajiController@cetakPDF');
    Route::get('/gaji/cetak-pdf-prive/{id}', 'GajiController@cetakPDFprive');

    // Laporan
    Route::get('/laporan', 'LaporanController@laporantampil')->name('laporanTampil');
    Route::get('/autocomplete-guru', 'LaporanController@autocompleteGuru')->name('autocompleteGuru');

    Route::get('/laporangaji', 'LaporanController@laporanGajitampil')->name('laporanGajiTampil');
    Route::get('/filter-gaji', 'LaporanController@laporanGajiTampil')->name('laporanGajiFilter');
    Route::get('/laporan-gaji/cetak-pdf', 'LaporanController@cetakPDFGaji')->name('cetakPDFGaji');

    Route::get('/laporanabsen', 'LaporanController@laporanTampilAbsen')->name('laporanAbsen');
    Route::get('/filter-absen', 'LaporanController@laporanTampilAbsen')->name('filterAbsen');
    Route::get('/laporan-absen/cetak-pdf', 'LaporanController@cetakPDFAbsen')->name('cetakPDFAbsen');

    Route::get('/laporanguru', 'LaporanController@laporanGurutampil')->name('laporanGuru');
    Route::get('/filter-guru', 'LaporanController@filterGuru')->name('filterGuru');
    Route::get('/laporan-guru/cetak-pdf', 'LaporanController@cetakPDFGuru')->name('cetakPDFGuru');

    // Contact
    Route::post('/contact', 'ContactController@tambah');
});
