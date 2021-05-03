<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\InfoController;
use App\Http\Controllers\Product\LaptopController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index', [InfoController::class, 'index']);
Route::prefix('products')->group(function () {
    Route::prefix('laptop')->group(function () {
        Route::resource('/', 'App\Http\Controllers\Product\LaptopController');
        Route::get('/create', [LaptopController::class, 'createForm']);
        Route::post('/create', [LaptopController::class, 'create']);
    });
});
Route::get('/token', function () {
    return csrf_token();
});

