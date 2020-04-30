<?php

use Illuminate\Http\Request;

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

Route::group(["prefix" => "auth"], function () {
    Route::post("/login", "SessionsController@store");
    Route::middleware(["JwtMiddleware"])->get("/refresh", "SessionsController@update");
});

Route::middleware(["JwtMiddleware"])->group(function () {

    Route::patch("/news/{id}/active", "NewsController@active");

    Route::apiResource("news", "NewsController")->except([
        'index', 'show'
    ]);
});

Route::apiResource("news", "NewsController")->only([
    'index', 'show'
]);

Route::post("/email", "EmailsController@store");
