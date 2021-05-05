<?php

use App\Http\Controllers\Product\InfoController;
use App\Http\Controllers\Product\LaptopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::get('/testApi','');
//Route::apiResource('test','App\Http\Controllers\Product\InfoController');
//Route::get('/test/{page?}', 'App\Http\Controllers\ProductController@test');
Route::prefix('products')->group(function () {
    Route::prefix('admin/products/')->group(function(){
        Route::get('/laptop', [LaptopController::class,'adminProducts']);
    });
    Route::get('/create', [LaptopController::class, 'getCreate']);
    Route::post('/create', [LaptopController::class, 'postCreate']);
    Route::get('/update/{id}', [LaptopController::class, 'getUpdate']);
    Route::post('/update', [LaptopController::class, 'postUpdate']);
});
