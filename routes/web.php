<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('landing');
});

Route::get('/landing', function () {
    return view('landing');
});

Route::get('/login', function () {
    return view('login');
});


Route::get('home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/menu', function () {
    return view('menu');
})->middleware('auth');

Route::get('/tentang', function () {
    return view('profile.tentang');
})->middleware('auth');

Route::get('/kontak', function () {
    return view('profile.kontak');
})->middleware('auth');

Route::get('/profil', function () {
    return view('profile.profil');
})->middleware('auth');

Route::get('/guru', 'GuruController@gurutampil')->middleware('auth');;
Route::post('/guru/tambah', 'GuruController@tambah')->middleware('auth');;
Route::get('/guru/edit/{id}', 'GuruController@edit')->middleware('auth');;
Route::post('/guru/update/{id}', 'GuruController@update')->middleware('auth');;
Route::delete('/guru/delete', 'GuruController@delete')->middleware('auth');;
Route::get('/guru/gajiperjam/{id}', 'GuruController@getGajiPerJam');

Route::get('/absen', 'AbsenController@absentampil')->middleware('auth');;
Route::post('/absen/tambah', 'AbsenController@tambah')->middleware('auth');;
Route::get('/absen/edit/{id}', 'AbsenController@edit')->middleware('auth');;
Route::post('/absen/update/{id}', 'AbsenController@update')->middleware('auth');;
Route::delete('/absen/delete', 'AbsenController@delete')->middleware('auth');;
Route::get('/absen/data/{id}', 'AbsenController@getDataAbsen');

Route::get('/gaji', 'GajiController@gajitampil')->middleware('auth');;
Route::post('/gaji/tambah', 'GajiController@tambah')->middleware('auth');;
Route::delete('/gaji/delete', 'GajiController@delete')->middleware('auth');;
Route::get('/gaji/cetak-pdf/{bulan}/{id?}', 'GajiController@cetakPDF');
Route::get('/gaji/cetak-pdf-prive/{id}', 'GajiController@cetakPDFprive');

// web.php atau api.php
Route::get('/absen/gajiperjam/{id}', 'GajiController@getGajiPerJam');
Route::get('/absen/data/{id}', 'GajiController@getAbsenData');
Route::get('/absen/idabsen/{id}', 'GajiController@getIdAbsen');

Route::get('/laporan', 'LaporanController@laporantampil')->middleware('auth');;
Route::get('/autocomplete-guru', 'LaporanController@autocompleteGuru')->name('autocompleteGuru');

Route::get('/laporangaji', 'LaporanController@laporanGajitampil')->middleware('auth');;
Route::get('/laporan-gaji', 'LaporanController@laporanGaji')->name('laporanGaji');
Route::get('/filter-gaji', 'LaporanController@filterGaji')->name('filterGaji');
Route::get('laporan-gaji/cetak-pdf', 'LaporanController@cetakPDFGaji')->name('cetakPDFGaji');

Route::get('/laporanabsen', 'LaporanController@laporanAbsentampil')->middleware('auth');;
Route::get('/laporan-absen', 'LaporanController@laporanAbsen')->name('laporanAbsen');
Route::get('/filter-absen', 'LaporanController@filterAbsen')->name('filterAbsen');
Route::get('/laporan-absen/cetak-pdf', 'LaporanController@cetakPDFAbsen')->name('cetakPDFAbsen');

Route::get('/laporanguru', 'LaporanController@laporanGurutampil')->middleware('auth');;
Route::get('/laporan-guru', 'LaporanController@LaporanGuru')->name('laporanGuru');
Route::get('/filter-guru', 'LaporanController@filterGuru')->name('filterGuru');
Route::get('/laporan-guru/cetak-pdf', 'LaporanController@cetakPDFGuru')->name('cetakPDFGuru');

Route::get('/login', 'LoginController@login')->name('login');
Route::post('loginaksi', 'LoginController@loginaksi')->name('loginaksi');
Route::post('/logout', 'LoginController@logout')->name('logout')->middleware('auth');

Route::post('/contact',  'ContactController@tambah')->middleware('auth');



