<?php

use Illuminate\Http\Request;
use Modules\Room\Http\Controllers\Api\RoomController;

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

Route::middleware('auth:api')->get('/room', function (Request $request) {
    return $request->user();
});

Route::apiResource('rooms', RoomController::class);
