<?php

use App\Http\Controllers\laporanController;
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
    return view('welcome');
});

Route::post('laporan/import', [laporanController::class, 'import'])->name('laporan');
Route::get('laporan', [laporanController::class, 'index'])->name('laporan.index');
Route::get('laporan-dataTable', [laporanController::class, 'dataTable'])->name('laporan.dataTable');
Route::get('laporan/{id}', [laporanController::class, 'edit'])->name('laporan.edit');
Route::put('laporan/{id}', [laporanController::class, 'update']);
Route::delete('laporan/{id}', [laporanController::class, 'destroy'])->name('laporan.destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
