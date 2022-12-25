<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Api workspace
Route::prefix('workspace')->group(function () {

    Route::get('/index', [WorkspaceController::class, 'index']);

    Route::post('/showbyid', [WorkspaceController::class, 'show']);

    Route::post('/add', [WorkspaceController::class, 'store']);

    Route::post('/remove', [WorkspaceController::class, 'destroy']);

    Route::post('/update', [WorkspaceController::class, 'update']);
});