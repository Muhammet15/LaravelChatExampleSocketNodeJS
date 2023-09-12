<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    Route::get('get/info', [MessageController::class, 'info']);
});
Route::middleware('auth:sanctum')->group(function () {

    Route::get('user/get/info', [MessageController::class, 'info']);
});
Route::post('login', [MessageController::class, 'login']);
Route::apiResource('messages', MessageController::class);
