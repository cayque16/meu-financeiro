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
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/home', [App\Http\Controllers\HomeController::class, 'index']);
  
    Route::get('/assets_type', [AssetsTypeController::class, 'index']);
    Route::get('/assets_type/create', [AssetsTypeController::class, 'create']);
    Route::post('/assets_type', [AssetsTypeController::class, 'store']);
    Route::get('/assets_type/edit/{uuid}', [AssetsTypeController::class, 'edit']);
    Route::post('/assets_type/update/{uuid}', [AssetsTypeController::class, 'update']);
    Route::get('/assets_type/enable/{uuid}/{value}', [AssetsTypeController::class, 'enable']);

    Route::get('/assets', [App\Http\Controllers\AssetsController::class, 'index']);
    Route::get('/assets/create', [App\Http\Controllers\AssetsController::class, 'create']);
    Route::post('/assets', [App\Http\Controllers\AssetsController::class, 'store']);
    Route::get('/assets/edit/{uuid}', [App\Http\Controllers\AssetsController::class, 'edit']);
    Route::post('/assets/update/{uuid}', [App\Http\Controllers\AssetsController::class, 'update']);
    Route::get('/assets/enable/{uuid}/{value}', [App\Http\Controllers\AssetsController::class, 'enable']);

    Route::get('/brokerages', [App\Http\Controllers\BrokeragesController::class, 'index']);
    Route::get('/brokerages/create', [App\Http\Controllers\BrokeragesController::class, 'create']);
    Route::post('/brokerages', [App\Http\Controllers\BrokeragesController::class, 'store']);
    Route::get('/brokerages/edit/{id}', [App\Http\Controllers\BrokeragesController::class, 'edit']);
    Route::post('/brokerages/update/{id}', [App\Http\Controllers\BrokeragesController::class, 'update']);
    Route::get('/brokerages/enable/{id}/{eExcluido}', [App\Http\Controllers\BrokeragesController::class, 'enable']);

    Route::get('/purchases', [App\Http\Controllers\PurchasesController::class, 'index']);
    Route::get('/purchases/create', [App\Http\Controllers\PurchasesController::class, 'create']);
    Route::post('/purchases', [App\Http\Controllers\PurchasesController::class, 'store']);
    Route::get('/purchases/edit/{id}', [App\Http\Controllers\PurchasesController::class, 'edit']);
    Route::post('/purchases/update/{id}', [App\Http\Controllers\PurchasesController::class, 'update']);
    Route::get('/purchases/enable/{id}/{eExcluido}', [App\Http\Controllers\PurchasesController::class, 'enable']);
    Route::post('/purchases/adicionaAtivos', [App\Http\Controllers\PurchasesController::class, 'adicionaAtivos']);
    Route::post('/purchases/removeAtivos', [App\Http\Controllers\PurchasesController::class, 'removeAtivos']);
    Route::get('/purchases/show/{id}', [App\Http\Controllers\PurchasesController::class, 'show']);
    Route::get('/purchases/exibirPdf/{id}', [App\Http\Controllers\PurchasesController::class, 'exibirPdf']);
});
