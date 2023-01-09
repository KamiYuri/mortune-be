<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardController;
use App\Models\User;
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

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/task', TaskController::class)->only('index');
});

Route::apiResource('user', UserController::class)->except(['create', 'update']);

//Board API
Route::apiResource('board', BoardController::class)->except(['store', 'edit']);
// Route::get('board', [BoardController::class, 'index']);
// Route::post('board', [BoardController::class, 'create']);
// Route::get('board/{id}', [BoardController::class, 'show']);
// Route::put('board/{id}', [BoardController::class, 'update']);
// Route::delete('board/{id}', [BoardController::class, 'destroy']);
