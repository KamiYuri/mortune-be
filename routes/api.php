<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardListController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\WorkspaceController;
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
    Route::apiResource('/user', UserController::class);
    Route::post('/user/authenticated', [UserController::class, "getAuthUser"]);

    Route::apiResource('/workspace', WorkspaceController::class);

    Route::apiResource('/board', BoardController::class);

    Route::apiResource('/cardlist', CardListController::class);
    Route::get('/cardlist/board/{board_id}', [CardListController::class, "getCardListByBoard"]);
    Route::get('/cardlist/cards', [CardListController::class, "getCardInfo"]);
    Route::post('/cardlist/board', [CardListController::class, "getByBoard"]);

    Route::apiResource('/card', CardController::class);
    Route::get('/card/cardlist/{list_id}', [CardController::class, "getCardByCardList"]);
    Route::post('/card/add_member', [CardController::class, 'addMemberToCard']);
    Route::post('/card/list_id', [CardController::class, "getByCardList"]);

});
