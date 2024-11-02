<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register AaPI routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Chatroom routes
Route::post('/chatroom/create', [ChatroomController::class, 'create']);
Route::get('/chatroom/list', [ChatroomController::class, 'list']);
Route::post('/chatroom/enter', [ChatroomController::class, 'enter']);
Route::post('/chatroom/leave', [ChatroomController::class, 'leave']);

// Message routes
Route::post('/message/send', [MessageController::class, 'send']);
Route::get('/messages/{chatroom_id}', [MessageController::class, 'list']);

