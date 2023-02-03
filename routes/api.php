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
    Route::post('/user/authenticated', [UserController::class, "getAuthUser"]);

    Route::apiResource('/user', UserController::class);
    Route::apiResource('/workspace', WorkspaceController::class);
    Route::apiResource('/board', BoardController::class);
    Route::apiResource('/cardlist', CardListController::class);
    Route::apiResource('/card', CardController::class);

    Route::get('/workspace/user/{id}', [WorkspaceController::class, 'getListUserByIdWs']);
    Route::get('/workspace/user/{id}', [WorkspaceController::class, "getWorkspaceByUserId"]);
    Route::post('/workspace/add_member', [WorkspaceController::class, "addMemberToWorkspace"]);

    Route::post('/board/boards_of_user/{id_user}', [BoardController::class, 'boards_of_user']);
    Route::post('/board/boards_with_workspace_of_user/{id_user}', [BoardController::class, 'boards_with_workspace_of_user']);
    Route::get('/board/workspace/{workspace_id}', [BoardController::class, 'boards_in_workspace_of_user']);
    Route::post('/board/get_membership_of_board/{id_board}', [BoardController::class, 'get_membership_of_board']);
    Route::post('/board/getWorkspaceByBoard/{id_board}', [BoardController::class, 'getWorkspaceByBoard']);
    Route::post('/board/getCardListsByBoard/{id_board}', [BoardController::class, 'getCardListsByBoard']);
    Route::post('/board/getMembersByBoard/{id_board}', [BoardController::class, 'getMembersByBoard']);
    Route::post('/board/add_member', [BoardController::class, 'addMemberToBoard']);

    Route::get('/cardlist/board/{board_id}', [CardListController::class, "getCardListByBoard"]);

    Route::get('/card/cardlist/{list_id}', [CardController::class, "getCardByCardList"]);
    Route::post('/card/add_member', [CardController::class, 'addMemberToCard']);

});




