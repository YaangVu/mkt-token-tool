<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register');
})->name('register');


Route::post('/clientSignUp', [AuthController::class, 'clientSignUp'])->name('clientSignUp');
