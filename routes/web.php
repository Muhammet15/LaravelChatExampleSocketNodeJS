<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/broadcasting/auth', function (Request $request) {
    return broadcast(new \Illuminate\Broadcasting\PrivateChannel($request->input('channel_name')));
})->middleware('auth:api');

Route::post('/broadcasting/auth', function (Request $request) {
    return broadcast(new \Illuminate\Broadcasting\PrivateChannel($request->input('channel_name')));
})->middleware('auth:api');


Route::middleware(['auth'])->group(function (){
    // Route::get('chat-deneme', [ChatController::class,'index2'])->name('chat-deneme');
    Route::get('chat-deneme/{id?}', [ChatController::class,'index2'])->name('chat-deneme');
    // Route::get('chat', [ChatController::class,'index']);
    // Route::post('chat/send', [ChatController::class,'send']);
});
Route::get('login', [MessageController::class, 'logins']);
Route::post('login', [MessageController::class, 'loginc']);

// Route::post('/websocket/message', 'WebSocketController@handleMessage');
