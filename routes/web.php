<?php

use App\Http\Controllers\Admin\DatatablesController;
use App\Http\Controllers\Admin\LayananController as AdminLayananController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
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
    return view('frontend.beranda');
});

Auth::routes();

// Admin Route
Route::prefix('admin')->group(function () {
    Route::get('/layanan/datatables', [DatatablesController::class, 'layanan'])->name('layanan.datatables');
    Route::middleware('admin')->group(function () {
        Route::get('/test', [TestController::class, 'index'])->name('dashboard.admin');
        Route::resource('/layanan', AdminLayananController::class);
    });

    //Datatables
    
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/backend.layanan', [App\Http\Controllers\LayananController::class, 'index']);
