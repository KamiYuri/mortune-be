<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardListController;
use App\Http\Controllers\CardController;
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

    Route::post('user/authenticated', [UserController::class, "getAuthUser"]);

    Route::resource('/user', UserController::class);

    Route::get('/cardlist/board/{board_id}', [CardListController::class, "getCardListByBoard"]);

    Route::get('/card/cardlist/{list_id}', [CardController::class, "getCardByCardList"]);
    Route::post('/card/add_member', [CardController::class, 'addMemberToCard']);

    Route::resource('/card', CardController::class);
    Route::post('/cardlist/board', [CardListController::class, "getByBoard"]);
    Route::post('/card/list_id', [CardController::class, "getByCardList"]);
    Route::get('/card_list/cards', [CardListController::class, "getCardInfo"]);
});
