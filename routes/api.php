<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\AuthorizedAccessTokenController;
use App\Http\Controllers\TransportController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user-list', [AuthController::class, 'userInfo']);
    Route::post('logout', [AuthController::class, 'logout']);
    // OAuth2 token routes
    Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);
    Route::post('/oauth/token/refresh', [AuthorizedAccessTokenController::class, 'refresh']);
    Route::post('/oauth/token/revoke', [AuthorizedAccessTokenController::class, 'revoke']);
    // Transport routes ...
    Route::post('/store', [TransportController::class, 'store']);
    Route::get('/list', [TransportController::class, 'index']);
    Route::get('/show/{id}', [TransportController::class, 'show']);
    Route::put('/update/{id}', [TransportController::class, 'update']);
    Route::delete('/delete/{id}', [TransportController::class, 'destroy']);
    Route::post('/transports/calculate-price', [TransportController::class, 'calculatePrice']);
});
