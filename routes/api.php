<?php

use App\Http\Controllers\API\SaleController;
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

//変更
Route::post('/purchase', [App\Http\Controllers\API\SaleController::class, 'processPurchase'])->withoutMiddleware(['auth']);

Route::get('/test', [SaleController::class, 'test'])->withoutMiddleware(['auth']);
