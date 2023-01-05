<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SosmedController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\RequestBrosurController;
use App\Http\Controllers\CounterSectionController;

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

Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
    Route::get('/getAll', [ProductController::class, 'getAll'])->name('product.getAll');
    Route::get('/getDetail/{slug}', [ProductController::class, 'getDetail'])->name('product.getDetail');
});

Route::group(['prefix' => 'facilities', 'as' => 'facilities.'], function() {
    Route::get('/getSelect', [FacilitiesController::class, 'getSelect'])->name('page.getSelect');
    Route::get('/getAll', [FacilitiesController::class, 'getAll'])->name('getData');
});

Route::group(['prefix' => 'page', 'as' => 'page.'], function() {
    Route::get('/getAll', [PageController::class, 'getAll'])->name('page.getAll');
    Route::get('/getDetail/{slug}', [PageController::class, 'getDetail'])->name('page.getDetail');
});

Route::group(['prefix' => 'slider', 'as' => 'slider.'], function() {
    Route::get('/getAll', [SliderController::class, 'getAll'])->name('getAll');
});

Route::group(['prefix' => 'request-brosur', 'as' => 'request-brosur.'], function() {
    Route::post('/{slug}', [RequestBrosurController::class, 'getStore'])->name('getStore');
});

Route::group(['prefix' => 'setting', 'as' => 'setting.'], function() {
    Route::get('/', [SettingController::class, 'getData'])->name('getData');
});

Route::group(['prefix' => 'sosmed', 'as' => 'sosmed.'], function() {
    Route::get('/getData', [SosmedController::class, 'getData'])->name('getData');
});

Route::group(['prefix' => 'counter-section', 'as' => 'counter-section.'], function() {
    Route::get('/getData', [CounterSectionController::class, 'getData'])->name('getData');
});

Route::group(['prefix' => 'about-us', 'as' => 'about-us.'], function() {
    Route::get('/getData', [AboutUsController::class, 'getData'])->name('getData');
});


