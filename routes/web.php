<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanoramaController;

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



Route::get('panorama', [PanoramaController::class, 'index'])->name('panorama');
Route::get('result/dolar', [PanoramaController::class, 'resultNrDolarFuture'])->name('resultDolarNrFuture');
Route::get('reload/dolar/future/b3', [PanoramaController::class, 'dolarFuture']);

///Route::get('panorama', 'App\Http\Controllers\PanoramaController@get');

///Route::get('/panorama', [PanoramaController::class], 'get');
