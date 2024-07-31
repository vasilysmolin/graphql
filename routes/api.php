<?php

use App\Http\Controllers\CdekController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Register API for company product controller.
 * File contains all methods for this controller.
 * Path prefix: /api/v1
 */
Route::controller(CdekController::class)
    ->group(function () {
        Route::group([
            'prefix' => '/cdek',
        ], function () {
            Route::get("/get-tariffs", "getTariffs");
        });
    });
