<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BackendControllerBase;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [BackendControllerBase::class, 'index'])->name('admin.index');
    Route::resource('/user', UserController::class)->names([
        'index'   => 'user.index',
        'create'  => 'user.create',
        'store'   => 'user.store',
        'show'    => 'user.show',
        'edit'    => 'user.edit',
        'update'  => 'user.update',
        'destroy' => 'user.destroy',
    ]);

    
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
});