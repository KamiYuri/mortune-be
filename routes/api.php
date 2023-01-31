<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardListController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\WorkspaceController;
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

    Route::resource('/card_list', CardListController::class);

    Route::resource('/card', CardController::class);
    Route::apiResource('workspace', WorkspaceController::class)->except(['create', 'edit']);
    Route::get('/cardlist/board/{board_id}', [CardListController::class, "getCardListByBoard"]);
    Route::get('/card/cardlist/{list_id}', [CardController::class, "getCardByCardList"]);
});

Route::resource('/task', TaskController::class);
Route::apiResource('workspace', WorkspaceController::class)->except(['create', 'edit']);
Route::get('/workspace/user/{id}', [WorkspaceController::class, "getWorkspaceByUserId"]);
Route::get('/card/cardlist/{list_id}', [CardController::class, "getCardByCardList"]);
Route::get('workspace/user/{id}', [WorkspaceController::class, 'getListUserByIdWs']);



