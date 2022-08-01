<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\RegisterController;

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


Route::middleware('auth:api')->group(function(){
    // Route After Login
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware('check.token')->group(function() {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class]);
});

