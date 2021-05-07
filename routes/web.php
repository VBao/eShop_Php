<?php
//
//use App\Http\Controllers\Controller;
//use App\Http\Controllers\Product\InfoController;
//use App\Http\Controllers\Product\LaptopController;
//use App\Http\Controllers\TestingController;
//use Illuminate\Support\Facades\Route;
//
///*
//|--------------------------------------------------------------------------
//| Web Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register web routes for your application. These
//| routes are loaded by the RouteServiceProvider within a group which
//| contains the "web" middleware group. Now create something great!
//|
//*/
//
//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/token', function () {
//    return csrf_token();
//});
//
//
//Route::get('/index', [InfoController::class, 'index']);
//Route::prefix('products')->group(function () {
//    Route::resource('laptop', LaptopController::class)
//        ->parameters([
//            'laptop' => 'id'
//        ])->except('update','create','edit','store','destroy');
//    Route::get('/create', [LaptopController::class, 'getCreate']);
//    Route::post('/create', [LaptopController::class, 'postCreate']);
//    Route::get('/update/{id}', [LaptopController::class, 'getUpdate']);
//    Route::post('/update', [LaptopController::class, 'postUpdate']);
//    Route::get('/search/{keywords}',[InfoController::class,'search']);
//});
//Route::get('test/',[TestingController::class,'testing']);
//
