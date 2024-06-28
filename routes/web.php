<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/konsumen', [KonsumenController::class, 'index']);
Route::get('/konsumen/{id}', [KonsumenController::class, 'get_kons']);
Route::post('/konsumen', [KonsumenController::class, 'store']);
Route::put('/konsumen', [KonsumenController::class, 'update']);
Route::delete('/konsumen', [KonsumenController::class, 'delete']);

Route::get('/paket', [PaketController::class, 'index']);
Route::get('/paket/{id}', [PaketController::class, 'getPaket']);
Route::post('/paket', [PaketController::class, 'store']);
Route::put('/paket', [PaketController::class, 'update']);
Route::delete('/paket', [PaketController::class, 'delete']);

Route::get('/pesanan', [PesananController::class, 'index']);
Route::get('/pesanan/baru', [PesananController::class, 'baru']);
Route::get('/ongoing', [PesananController::class, 'ongoing'])->name('home');
Route::get('/pesanan/{no_nota}', [PesananController::class, 'edit']);
Route::post('/pesanan/simpan', [PesananController::class, 'store']);
Route::post('/pesanan/step2', [PesananController::class, 'baru_next']);
Route::put('/pesanan', [PesananController::class, 'update']);
Route::delete('/pesanan', [PesananController::class, 'delete']);

Route::get('/nota/{no_nota}', [NotaController::class, 'getNota']);

Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user', [UserController::class, 'update']);
Route::delete('/user', [UserController::class, 'delete']);

Route::get('/profile', [ProfileController::class, 'index']);
Route::put('/profile', [ProfileController::class, 'update']);
Route::put('/profile/ganti-password', [ProfileController::class, 'changePassword']);

Route::get('/rekap-harian', [PesananController::class, 'getHarian']);
Route::get('/rekap-harian-filtered', [PesananController::class, 'filterHarian']);
Route::get('/rekap-bulanan', [PesananController::class, 'getBulanan']);
Route::get('/rekap-bulanan-filtered', [PesananController::class, 'filterBulanan']);
Route::get('/rekap-tahunan', [PesananController::class, 'getTahunan']);
Route::get('/rekap-tahunan-filtered', [PesananController::class, 'filterTahunan']);
Route::get('/rekap-lunch', [PesananController::class, 'rekapLunch']);
Route::get('/rekap-dinner', [PesananController::class, 'rekapDinner']);
