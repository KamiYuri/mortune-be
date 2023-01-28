<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkspaceController;
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

Route::apiResource('user', UserController::class)->except(['create', 'update']);


//Api workspace
Route::apiResource('workspace', WorkspaceController::class)->except(['create', 'edit']);
Route::get('workspace/user/{id}', [WorkspaceController::class, 'getListUserByIdWs']);
//Route::post('/workspace/{id}', [WorkspaceController::class, 'update']);
// Route::prefix('workspace')->group(function () {

//     Route::get('/index', [WorkspaceController::class, 'index']);

//     Route::post('/showbyid', [WorkspaceController::class, 'show']);

//     Route::post('/add', [WorkspaceController::class, 'store']);

//     Route::post('/remove', [WorkspaceController::class, 'destroy']);

//     Route::post('/update', [WorkspaceController::class, 'update']);
// });