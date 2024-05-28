<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PesananController;
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

Route::get('/konsumen', [KonsumenController::class, 'index'])->name('home');
Route::get('/konsumen/{id}', [KonsumenController::class, 'get_kons']);
Route::post('/konsumen', [KonsumenController::class, 'store']);
Route::put('/konsumen', [KonsumenController::class, 'update']);
Route::delete('/konsumen', [KonsumenController::class, 'delete']);

Route::get('/paket', [PaketController::class, 'index']);
Route::post('/paket', [PaketController::class, 'store']);
Route::put('/paket', [PaketController::class, 'update']);
Route::delete('/paket', [PaketController::class, 'delete']);

Route::get('/pesanan', [PesananController::class, 'index']);
Route::get('/pesanan/baru', [PesananController::class, 'baru']);
Route::post('/pesanan/tambah', [PesananController::class, 'store']);
