<?php

use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Product\DriveController;
use App\Http\Controllers\Product\InfoController;
use App\Http\Controllers\Product\LaptopController;
use App\Http\Controllers\Account\PurchaseController;


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

Route::get('/', [InfoController::class, 'index']);

// Anonymous routes group
Route::prefix('products')->group(function () {
    Route::post('/filter', [InfoController::class, 'filter']);
    Route::prefix('laptop')->group(function () {
        Route::get('/filter', [LaptopController::class, 'getFilter']);
        Route::post('/filter', [LaptopController::class, 'postFilter']);
        Route::post('/list/{page}', [InfoController::class, 'index']);
        Route::get('/get/{id}', [LaptopController::class, 'show']);
    });
    Route::prefix('drive')->group(function () {
        Route::get('/get/{id}', [DriveController::class, 'show']);
        Route::get('/filter', [DriveController::class, 'getFilter']);
        Route::post('/filter', [DriveController::class, 'postFilter']);
    });
});

// User routes group
Route::group(['middleware' => ['check_login']], function () {
    Route::post('/cart_post', [PurchaseController::class, 'purchase']);
    Route::get('/orders', [PurchaseController::class, 'orders']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::prefix('/account')->group(function () {
        Route::post('update_info', [UserController::class, 'updateInfo']);
        Route::post('change_password', [UserController::class, 'changePassword']);
        Route::post('reset-password', [UserController::class, 'resetPassword'])->name('password.reset');
    });
});

// Admin route group
Route::group(['middleware' => ['role.isAdmin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('orders', [PurchaseController::class, 'ordersAdmin']);
        Route::get('orderStat/order_id/{orderId}/stat/{stat}', [PurchaseController::class, 'changeStats']);
        Route::prefix('/account')->group(function () {
            Route::get('user', [UserController::class, 'users']);
            Route::post('new_admin', [UserController::class, 'createAdmin']);
        });
        Route::prefix('/products')->group(function () {
            Route::get('/spec_list', [InfoController::class, 'getAllSpecs']);
            Route::post('/discount', [InfoController::class, 'setDiscount']);
            Route::put('/discount', [InfoController::class, 'putDiscount']);
            Route::get('/delete_discount/{id}', [InfoController::class, 'delDiscount']);
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

Route::post('forget_password', [UserController::class, 'forgetPassword']);
Route::post('login', [UserController::class, 'authenticate']);
Route::post('register', [UserController::class, 'register']);
Route::post('search', [InfoController::class, 'search']);
Route::post('test', [InfoController::class, 'test']);


