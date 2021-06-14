<?php

use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Product\DriveController;
use App\Http\Controllers\Product\InfoController;
use App\Http\Controllers\Product\LaptopController;
use App\Http\Controllers\PurchaseController;
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

Route::get('/', [InfoController::class, 'index']);
Route::prefix('products')->group(function () {
    Route::post('/filter', [InfoController::class, 'filter']);
    Route::prefix('laptop')->group(function () {
        Route::get('/filter', [LaptopController::class, 'getFilter']);
        Route::post('/filter', [LaptopController::class, 'postFilter']);
        Route::post('/list/{page}', [InfoController::class, 'index']);
        Route::get('/get/{id}', [LaptopController::class, 'show']);
        Route::get('/search/{keywords}', [InfoController::class, 'search']);
    });
    Route::prefix('drive')->group(function () {
        Route::get('/get/{id}', [DriveController::class, 'show']);
        Route::post('/filter', [DriveController::class, 'postFilter']);
        Route::get('/search/{keywords}', [InfoController::class, 'search']);
        Route::get('/list', [DriveController::class, 'index']);
    });
});

Route::group(['middleware' => ['check_login']], function () {
    Route::post('/cart_info', [PurchaseController::class, 'cart_info']);
    Route::post('/cart_post', [PurchaseController::class, 'purchase']);
    Route::get('/order/{id}', [PurchaseController::class, 'detail']);
    Route::get('/orders', [PurchaseController::class, 'orders']);
    Route::prefix('/account')->group(function () {
        Route::post('reset-password', [UserController::class, 'reset_password']);
    });
});
Route::group(['middleware' => ['role.isAdmin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('orders', [PurchaseController::class, 'ordersAdmin']);
        Route::get('orderStat/order_id/{orderId}/stat/{stat}', [PurchaseController::class, 'changeStats']);
        Route::prefix('/account')->group(function () {
            Route::post('role', [UserController::class, 'role']);
        });
        Route::prefix('/products')->group(function () {
            Route::get('/spec_list', [InfoController::class, 'getAllSpecs']);
            Route::prefix('laptop')->group(function () {
                Route::get('/index', [LaptopController::class, 'adminProducts']);
                Route::get('/create', [LaptopController::class, 'getCreate']);
                Route::post('/create', [LaptopController::class, 'postCreate']);
                Route::get('/update/{id}', [LaptopController::class, 'getUpdate']);
                Route::post('/update', [LaptopController::class, 'postUpdate']);
            });
            Route::prefix('drive')->group(function () {
                Route::get('/index', [DriveController::class, 'adminProducts']);
                Route::get('/create', [DriveController::class, 'getCreate']);
                Route::post('/create', [DriveController::class, 'postCreate']);
                Route::get('/update/{id}', [DriveController::class, 'getUpdate']);
                Route::post('/update', [DriveController::class, 'postUpdate']);
            });
        });
    });
});

Route::post('login', [UserController::class, 'authenticate']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout']);


