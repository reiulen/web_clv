<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IconController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\RequestBrosurController;
use App\Http\Controllers\Admin\TypePageController;
use App\Http\Controllers\Admin\TextEditorController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('admin')
->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'textEditor'], function() {
        Route::post('/uploadPhoto',  [TextEditorController::class, 'uploadPhoto'])->name('uploadPhoto');
        Route::post('/deletePhoto',  [TextEditorController::class, 'deletePhoto'])->name('deletePhoto');
    });

    Route::group(['prefix' => 'blog', 'as' => 'blog.'], function() {
        Route::resource('/artikel', ArtikelController::class);
        Route::post('/artikel/dataTable', [ArtikelController::class, 'dataTable'])->name('artikel.dataTable');
    });

    Route::group(['prefix' => 'page', 'as' => 'page.'], function() {
        Route::resource('type_page', TypePageController::class);
        Route::post('/type_page/dataTable', [TypePageController::class, 'dataTable'])->name('type_page.dataTable');
        Route::resource('/halaman', PageController::class);
        Route::post('/dataTable', [PageController::class, 'dataTable'])->name('page.dataTable');
    });

    Route::group(['prefix' => 'facilities', 'as' => 'facilities.'], function() {
        Route::resource('/', FacilitiesController::class);
        Route::get('/{id}/edit', [FacilitiesController::class, 'edit'])->name('edit');
        Route::delete('/{id}', [FacilitiesController::class, 'destroy'])->name('destroy');
        Route::post('/dataTable', [FacilitiesController::class, 'dataTable'])->name('facilities.dataTable');
    });

    Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
        Route::resource('/', ProductController::class);
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/edit', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/dataTable', [ProductController::class, 'dataTable'])->name('dataTable');
        Route::post('/summaryDetail/store', [ProductController::class, 'summaryDetailStore'])->name('summaryDetailStore');
        Route::delete('/summaryDetail/delete/{id}', [ProductController::class, 'summaryDetailDelete'])->name('summaryDetailDelete');
        Route::post('/dataTable/summaryDataTable', [ProductController::class, 'summaryDataTable'])->name('summaryDataTable');
        Route::post('/detail/store', [ProductController::class, 'detailStore'])->name('detailStore');
        Route::delete('/detail/delete/{id}', [ProductController::class, 'detailDelete'])->name('detailDelete');
        Route::post('/dataTable/detailDataTable', [ProductController::class, 'detailDataTable'])->name('detailDataTable');
    });

    Route::group(['prefix' => 'icon', 'as' => 'icon.'], function() {
        Route::resource('/', IconController::class);
        Route::get('/getData/select2', [IconController::class, 'getIcons'])->name('getIcons');
        Route::post('/dataTable', [IconController::class, 'dataTable'])->name('dataTable');
    });

    Route::group(['prefix' => 'popup', 'as' => 'popup.'], function() {
        Route::resource('', PopupController::class);
        Route::get('/edit/{id}', [PopupController::class, 'edit'])->name('edit');
        Route::put('/{id}/edit', [PopupController::class, 'update'])->name('update');
        Route::delete('/{id}', [PopupController::class, 'destroy'])->name('destroy');
        Route::post('/dataTable', [PopupController::class, 'dataTable'])->name('dataTable');
    });


    Route::group(['prefix' => 'slider', 'as' => 'slider.'], function() {
        Route::resource('/', SliderController::class);
        Route::get('/{id}/edit', [SliderController::class, 'edit'])->name('edit');
        Route::delete('/{id}', [SliderController::class, 'destroy'])->name('destroy');
        Route::post('/updown/{id}', [SliderController::class, 'updown'])->name('updown');
        Route::post('/dataTable', [SliderController::class, 'dataTable'])->name('dataTable');
    });

    Route::group(['prefix' => 'request-brosur', 'as' => 'request-brosur.'], function() {
        Route::get('/', [RequestBrosurController::class, 'index'])->name('index');
        Route::post('/dataTable', [RequestBrosurController::class, 'dataTable'])->name('dataTable');
    });

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function() {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'store'])->name('store');
    });

});
