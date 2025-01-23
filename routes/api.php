<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StripeWebhookController;


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

    Route::group(
        [
            "prefix" => "list",
            "middleware" => []
        ],
        function() {
            Route::get("/users", [UserController::class, "listAllUsers"]);
            Route::get("/products", [ProductController::class, "listAllProducts"]);
        }
    );


    Route::group(
        [
            "prefix" => "/user",
            "middleware" => []
        ],
        function() {
            Route::post("/store", [UserController::class, "store"]);
            Route::put("/update/{id}", [UserController::class, "update"]);
        }
    );

    Route::group(
        [
            "prefix" => "/product",
            "middleware" => []
        ],
        function(){
            Route::post('/store', [ProductController::class, 'store']);
            Route::get('/item/{id}', [ProductController::class, 'getProductById']);
        }
    );

    Route::group(
        [
            "prefix" => "/webhook",
            "middleware" => []
        ],
        function(){
            Route::post('/stripe', [StripeWebhookController::class, 'handle']);

        }
    );

