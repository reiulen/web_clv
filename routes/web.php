<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArtikelController;
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
    });
});
