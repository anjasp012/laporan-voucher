<?php

use App\Http\Controllers\LaporanController;
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

Route::post('laporan/import', [LaporanController::class, 'import'])->name('laporan');
Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('laporan-dataTable', [LaporanController::class, 'dataTable'])->name('laporan.dataTable');
Route::get('laporan/{id}', [LaporanController::class, 'edit'])->name('laporan.edit');
Route::put('laporan/{id}', [LaporanController::class, 'update']);
Route::delete('laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
