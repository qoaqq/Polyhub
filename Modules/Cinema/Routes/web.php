<?php

use Illuminate\Support\Facades\Route;
use Modules\Cinema\Http\Controllers\CinemaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('cinema')->name('cinema.')->group(function () {
        Route::get('/', [CinemaController::class, 'index'])->name('index');
        Route::get('/create', [CinemaController::class, 'create'])->name('create');
        Route::post('/create', [CinemaController::class, 'store'])->name('create');
        Route::get('/detail/{id}', [CinemaController::class, 'show'])->name('detail');
        Route::post('/update/{id}', [CinemaController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CinemaController::class, 'destroy'])->name('delete');
    });
});

