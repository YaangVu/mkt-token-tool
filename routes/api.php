<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\TokenDumpHistoryController;
use App\Http\Middleware\TeamMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/client/login', [AuthController::class, 'clientSignIn']);

Route::group(['middleware' => ['auth:sanctum', TeamMiddleware::class]], function () {
    Route::post('/client/download/kernel', [FileDownloadController::class, 'downloadKernel']);

    Route::get('/client/skus', [SkuController::class, 'getList']);
    Route::get('/client/skus-has-tokens', [SkuController::class, 'getListSkusHasTokens']);
    Route::get('/client/skus/product-id/{productId}', [SkuController::class, 'getSkuByProductId']);

    Route::post('/client/tokens', [TokenController::class, 'store']);
    Route::patch('/client/tokens/{id}/update-status', [TokenController::class, 'updateStatus']);

    Route::post('/client/tokens/dump/{productId}', [TokenDumpHistoryController::class, 'dump']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/client/logout', [AuthController::class, 'clientSignOut']);
});
