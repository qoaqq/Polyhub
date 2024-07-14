<?php

use App\Http\Controllers\api\AuthClientController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->group(function () {
    //Auth
    Route::controller(AuthClientController::class)->group(function () {
        Route::post('/signin', 'signin')->name('signin');
        Route::post('/signout', 'signout');
        Route::post('/signup', 'signup');
        Route::get('/user', 'getUser')->middleware('auth:api');
        Route::put('/user', 'updateUser')->middleware('auth:api');
    });
});
