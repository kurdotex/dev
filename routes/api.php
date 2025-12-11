<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'user'], function() {
    Route::post('/store', [UserController::class, 'store']);
});

Route::group(['prefix' => 'list'], function() {

    /*
    |--------------------------------------------------------------------------
    | Rutas privadas (Requieren Token Bearer en el Header)
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::group(['prefix' => 'user'], function () {
            Route::put('/update/{id}', [UserController::class, 'update']);
        });

        Route::group(['prefix' => 'list'], function () {
            Route::get('/users', [UserController::class, 'listAllUsers']);
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::post('/', [OrderController::class, 'store']);
            Route::get('/{id}', [OrderController::class, 'getOrderById']);
        });

    });

});
