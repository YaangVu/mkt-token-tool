<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileDownloadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sign-in', [AuthController::class, 'signIn']);

Route::post('/gambler/game/android/pro/plugin/inject/kernel', [FileDownloadController::class, 'downloadKernel']);
