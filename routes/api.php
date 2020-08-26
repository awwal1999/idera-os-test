<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ShowController;
use Illuminate\Http\Request;
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

Route::post('/users', [AuthController::class, 'createUser']);
Route::post('login', [AuthController::class, 'login']);
Route::get('shows', [ShowController::class, 'getShows']);
Route::get('shows/{id}/cinemas', [ShowController::class, 'getCinemas']);

Route::get('cinemas', [CinemaController::class, 'getCinemas']);
Route::get('cinemas/{id}/shows', [CinemaController::class, 'getShows']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('shows', [ShowController::class, 'createShows']);
    Route::post('cinemas/{id}/shows', [CinemaController::class, 'addShow']);
});

Route::fallback(function () {
    return [
        'message' => 'Url does not exist'
    ];
});
