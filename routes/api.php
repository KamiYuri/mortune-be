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
    Route::resource('/task', TaskController::class);

    Route::post('user/authenticated', [UserController::class, "getAuthUser"]);

    Route::resource('/user', UserController::class);

    Route::resource('/card_list', CardListController::class);

    Route::resource('/card', CardController::class);
    Route::post('/cardlist/board', [CardListController::class, "getByBoard"]);
    Route::post('/card/list_id', [CardController::class, "getByCardList"]);
    Route::get('/card_list/cards', [CardListController::class, "getCardInfo"]);
});

Route::resource('/task', TaskController::class);
Route::post('/card_list_info', [CardListController::class, "getCardInfo"]);

