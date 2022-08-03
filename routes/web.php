<?php

use App\Http\Controllers\AssetsTypeController;
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

Route::get('/teste', function () {
    return view('teste');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/assets_type', [App\Http\Controllers\AssetsTypeController::class, 'index']);
    Route::get('/assets_type/create', [App\Http\Controllers\AssetsTypeController::class, 'create']);
    Route::post('/assets_type', [App\Http\Controllers\AssetsTypeController::class, 'store']);

});
