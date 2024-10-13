<?php

use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/gambler/user/child/login', [ClientAuthController::class, 'signIn']);

Route::post('/gambler/game/android/pro/plugin/inject/kernel', [FileDownloadController::class, 'downloadKernel']);

Route::get('/gambler/game/android/pro/package/sku', [PackageController::class, 'getList']);

Route::post('/gambler/game/android/pro/purchase/import', [TokenController::class, 'addToken']);
