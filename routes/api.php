<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/client/login', [AuthController::class, 'clientSignIn']);

Route::post('/client/download/kernel', [FileDownloadController::class, 'downloadKernel']);

Route::get('/client/packages', [PackageController::class, 'getList']);

Route::post('/client/tokens', [TokenController::class, 'addToken']);
