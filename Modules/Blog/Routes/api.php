<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\API\BlogController;

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

Route::middleware('auth:api')->get('/blog', function (Request $request) {
    return $request->user();
});

Route::resource('blog',BlogController::class);
Route::get('blog-home', [BlogController::class, 'bloghome']);
Route::get('getAllCategory', [BlogController::class, 'getAllCategory']);
Route::get('getBlogByCategory/{categoryId}', [BlogController::class, 'getBlogByCategory']);
Route::get('getYearsAndCounts', [BlogController::class, 'getYearsAndCounts']);
Route::get('getBlogsByYear/{year}', [BlogController::class, 'getBlogsByYear']);
Route::get('searchBlogs', [BlogController::class, 'searchBlogs']);
