<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\TournamentController;
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

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('/register', 'createUser');
        Route::post('/login', 'loginUser');
        Route::post('/logout', 'logoutUser');
});

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('player', PlayerController::class);
        Route::apiResource('tournament', TournamentController::class);
        Route::post('/tournament/start', [TournamentController::class, 'start']);
});
