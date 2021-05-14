<?php

use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Product\DriveController;
use App\Http\Controllers\Product\InfoController;
use App\Http\Controllers\Product\LaptopController;
use App\Http\Controllers\TestingController;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Route;


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
    Route::prefix('laptop')->group(function () {
        Route::get('/list/', [InfoController::class, 'index']);
        Route::get('/create', [LaptopController::class, 'getCreate']);
        Route::get('/get/{id}', [LaptopController::class, 'show']);
        Route::post('/create', [LaptopController::class, 'postCreate']);
        Route::get('/update/{id}', [LaptopController::class, 'getUpdate']);
        Route::post('/update', [LaptopController::class, 'postUpdate']);
        Route::get('/search/{keywords}', [InfoController::class, 'search']);
    });
    Route::prefix('drive')->group(function(){
        Route::get('/get/{id}', [DriveController::class, 'show']);
        Route::get('/create', [DriveController::class, 'getCreate']);
        Route::post('/create', [DriveController::class, 'postCreate']);
        Route::get('/update/{id}', [DriveController::class, 'getUpdate']);
        Route::post('/update', [DriveController::class, 'postUpdate']);
        Route::get('/search/{keywords}', [InfoController::class, 'search']);
        Route::get('/list/{page=0}', [DriveController::class, 'index']);
    });

});
//,'role.isAdmin'
Route::group(['middleware' => ['api']], function () {
    Route::group(['middleware' => ['role.isAdmin']], function () {
        Route::prefix('admin')->group(function () {
            Route::prefix('/products')->group(function () {
                Route::get('/index', [LaptopController::class, 'adminProducts']);
            });
        });
    });
});
Route::post('login', [UserController::class, 'authenticate']);
Route::post('register', [UserController::class, 'register']);

Route::post('/test',[TestingController::class,'testing4']);
