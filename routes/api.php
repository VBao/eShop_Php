<?php

use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Product\InfoController;
use App\Http\Controllers\Product\LaptopController;
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

Route::get('/', [InfoController::class, 'index']);
Route::prefix('products')->group(function () {
    Route::resource('laptop', LaptopController::class)
        ->parameters([
            'laptop' => 'id'
        ])->except('update', 'create', 'edit', 'store', 'destroy');
    Route::get('/create', [LaptopController::class, 'getCreate']);
    Route::post('/create', [LaptopController::class, 'postCreate']);
    Route::get('/update/{id}', [LaptopController::class, 'getUpdate']);
    Route::post('/update', [LaptopController::class, 'postUpdate']);
    Route::get('/search/{keywords}', [InfoController::class, 'search']);
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


//Route::filter('/test',[\App\Http\Controllers\TestingController::class,'testing2']);
