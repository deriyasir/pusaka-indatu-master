<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RajaOngkirController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-province', [RajaOngkirController::class, 'getProvince']);
Route::get('/get-city/{provinceId}', [RajaOngkirController::class, 'getCity']);
Route::get('/get-cost/{origin}/{destination}/{weight}/{courier}', [RajaOngkirController::class, 'getCost']);

Route::post('/notification', [CheckoutController::class, 'notification']);
