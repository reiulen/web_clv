<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArtikelController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'blog', 'as' => 'blog.'], function() {
    Route::get('/artikel/getAll', [ArtikelController::class, 'getAll'])->name('artikel.getData');
    Route::get('/artikel/getDetail/{slug}', [ArtikelController::class, 'getDetail'])->name('artikel.getDetail');
});
