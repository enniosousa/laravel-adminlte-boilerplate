<?php

use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthApiController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthApiController::class, 'register'])->name('auth.register');
    Route::post('logout', [AuthApiController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
    Route::get('me', [AuthApiController::class, 'me'])->name('auth.me')->middleware('auth:sanctum');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UserApiController::class);
});
