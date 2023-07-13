<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\GetPriceController;
use App\Http\Controllers\OrderFlightController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Use imported controller
//Route::get('/init', AccessTokenController::class);
//Route::post('/price', GetPriceController::class);
//Route::post('/search', FlightSearchController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/init', AccessTokenController::class);
Route::post('/search', [GetPriceController::class, '__invoke'])->name('__invoke');
//Route::match(['get', 'post'], '/search', [GetPriceController::class, '__invoke'])->name('__invoke');
//Route::post('/price', [GetPriceController::class, '__invoke'])->name('price');

Route::match(['get', 'post'], '/price', [GetPriceController::class, '__invoke'])->name('__invoke');

Route::post('/order', OrderFlightController::class);