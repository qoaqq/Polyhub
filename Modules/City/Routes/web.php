<?php

use Illuminate\Support\Facades\Route;
use Modules\City\Http\Controllers\CityController;

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
    Route::prefix('city')->name('city.')->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('index');
        Route::get('/create', [CityController::class, 'create'])->name('create');
        Route::post('/create', [CityController::class, 'store'])->name('create');
        Route::get('/detail/{id}', [CityController::class, 'show'])->name('detail');
        Route::post('/update/{id}', [CityController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CityController::class, 'destroy'])->name('delete');
    });
});
