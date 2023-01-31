<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BoardController;
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
    Route::post('/cardlist/board', [CardListController::class, "getByBoard"]);
    Route::apiResource('board', BoardController::class)->except(['store', 'edit']);
    
    Route::post('board/boards_of_user/{id_user}', [BoardController::class, 'boards_of_user']);
    Route::post('board/boards_with_workspace_of_user/{id_user}', [BoardController::class, 'boards_with_workspace_of_user']);
    Route::post('board/boards_in_workspace_of_user/{id_user}/{id_workspace}', [BoardController::class, 'boards_in_workspace_of_user']);
    Route::post('board/get_membership_of_board/{id_board}', [BoardController::class, 'get_membership_of_board']);
    
    Route::post('board/getWorkspaceByBoard/{id_board}', [BoardController::class, 'getWorkspaceByBoard']);
    Route::post('board/getCardListsByBoard/{id_board}', [BoardController::class, 'getCardListsByBoard']);
    Route::post('board/getMembersByBoard/{id_board}', [BoardController::class, 'getMembersByBoard']);
}); 

Route::resource('/task', TaskController::class);
Route::get('/workspace/user/{id}', [WorkspaceController::class, "getWorkspaceByUserId"]);
