<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\RoomController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/feature', [FeatureController::class, 'index']);
Route::post('/feature', [FeatureController::class, 'store']);
Route::put('/feature/{id}', [FeatureController::class, 'update']);
Route::delete('/feature/{id}', [FeatureController::class, 'destroy']);

Route::get('/room', [RoomController::class, 'index']);
Route::post('/room', [RoomController::class, 'store']);
Route::put('/room/{id}', [RoomController::class, 'update']);
Route::delete('/room/{id}', [RoomController::class, 'destroy']);

