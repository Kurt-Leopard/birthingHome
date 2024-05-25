<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\api\v1\StudentsController;

// use App\Http\Controllers\UserController;
use App\Http\Controllers\api\v1\StudentsController;

use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->post('/user', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->post('/user/{id}', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/user/{id}', [UserController::class, 'destroy']);



Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);