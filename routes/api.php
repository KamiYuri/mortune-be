<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;
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
    Route::resource('/task', TaskController::class);

    Route::post('user/authenticated', [UserController::class, "getAuthUser"]);

    Route::resource('/user', UserController::class);
});
Route::apiResource('board', BoardController::class)->except(['store', 'edit']);
Route::post('board/boards_of_user/{id_user}', [BoardController::class, 'boards_of_user']);
Route::post('board/boards_with_workspace_of_user/{id_user}', [BoardController::class, 'boards_with_workspace_of_user']);
Route::post('board/boards_in_workspace_of_user/{id_user}/{id_workspace}', [BoardController::class, 'boards_in_workspace_of_user']);

Route::resource('/task', TaskController::class);
