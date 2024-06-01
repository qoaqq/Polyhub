<?php

use Illuminate\Support\Facades\Route;
use Modules\Seat\Http\Controllers\SeatController;

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
    Route::prefix('seat')->name('seat.')->group(function () {
        Route::get('/', [SeatController::class, 'index'])->name('index');
        Route::get('/detail{id}', [SeatController::class, 'show'])->name('detail');
    });
});
