<?php

use App\Http\Controllers\CheckTransactionsController;
use App\Http\Controllers\LogsDecoderController;
use Illuminate\Support\Facades\Route;

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

Route::post('/transaction', CheckTransactionsController::class);
Route::post('/logs/dehash', LogsDecoderController::class);

Route::fallback(function (){
    abort(404, 'API resource not found');
});
