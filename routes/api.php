<?php

use App\Http\Controllers\PostKhsController;
use App\Http\Controllers\PostPiketController;
use App\Http\Controllers\PostTagihanController;
use App\Http\Controllers\PostUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//posts
Route::apiResource('/postUsers', PostUserController::class);

Route::apiResource('/postKhss', PostKhsController::class);

Route::apiResource('/postPikets', PostPiketController::class);

Route::apiResource('/postTagihans', PostTagihanController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
