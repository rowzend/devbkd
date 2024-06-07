<?php

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
    Route::middleware('admin')->group(function () {
        Route::get('/test', [TestController::class, 'index'])->name('dashboard.admin');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/backend.layanan', [App\Http\Controllers\LayananController::class, 'index']);
